CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_attribute_create`(
	IN schema_id INT,
  IN attribute_name VARCHAR(255) CHARSET utf8,
  IN label VARCHAR(255) CHARSET utf8,
  IN description TEXT CHARSET utf8,
	IN input_type VARCHAR(255) CHARSET utf8,
	IN data_type VARCHAR(255) CHARSET utf8,
	IN field_validation TEXT CHARSET utf8,
	IN attribute_option TEXT CHARSET utf8,
	IN default_value VARCHAR(255) CHARSET utf8,
	OUT alert_message TEXT CHARSET utf8,
	OUT return_id INT
)
BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET alert_message = "SQL EXCEPTION ERROR; Procedure Name : sp_attribute_create";
	END;

	#DECLARE EXIT HANDLER FOR SQLWARNING
	#BEGIN
		#SET alert_message = "SQL WARNING; Procedure Name : sp_attribute_create";
	#END;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET alert_message = "SQL CONTINUE HANDLER; Procedure Name : sp_attribute_create";

    SET @attributes_id = NULL;
    SET @data_types_id = NULL;
    SET @input_types_id = NULL;


    IF EXISTS (SELECT * FROM `schema` WHERE `schema`.`id` = schema_id) THEN

      SELECT `id` INTO @data_types_id FROM `data_types` WHERE `name` = data_type;
      SELECT `id` INTO @input_types_id FROM `input_types` WHERE `name` = input_type;

      IF @data_types_id IS NULL THEN
        INSERT INTO `data_types`(`name`) VALUES (data_type);
        SET @data_types_id = LAST_INSERT_ID();
      END IF;

      IF @input_types_id IS NULL THEN
        INSERT INTO `input_types`(`name`) VALUES (input_type);
        SET @input_types_id = LAST_INSERT_ID();
      END IF;

      IF EXISTS (SELECT `attributes`.`id` FROM `attributes` WHERE `attributes`.`schema_id` = schema_id AND `attributes`.`name` = attribute_name) THEN

        SELECT `attributes`.`id` INTO @attributes_id FROM `attributes` WHERE `attributes`.`schema_id` = schema_id AND `attributes`.`name` = attribute_name;

        UPDATE `attributes`
        SET
          `input_types_id` = @input_types_id,
          `data_types_id` = @data_types_id,
          `validation` = field_validation,
          `label` = label,
          `description` = description
        WHERE id = @attributes_id;

        IF attribute_option IS NOT NULL AND attribute_option != '' THEN
        IF EXISTS (SELECT * FROM `attribute_options` WHERE `attributes_id` = @attributes_id) THEN
          UPDATE `attribute_options` SET `value` = attribute_option WHERE `attributes_id` = @attributes_id;
        ELSE
          INSERT INTO `attribute_options` (`attributes_id`, `value`) VALUES (@attributes_id, attribute_option);
        END IF;

        ELSE
          DELETE FROM `attribute_options` WHERE `attribute_options`.`attributes_id` = @attributes_id;
        END IF;

        IF default_value IS NOT NULL AND default_value != '' THEN

        IF EXISTS (SELECT * FROM `attribute_default_values` WHERE `attributes_id` = @attributes_id) THEN
          UPDATE `attribute_default_values` SET `value` = default_value WHERE `attributes_id` = @attributes_id;
        ELSE
          INSERT INTO `attribute_default_values` (`attributes_id`,`value`) VALUES (@attributes_id, default_value);
        END IF;

        ELSE
          DELETE FROM `attribute_default_values` WHERE `attribute_default_values`.`attributes_id` = @attributes_id;
        END IF;

      ELSE


        INSERT INTO `attributes` (`schema_id`,`input_types_id`,`data_types_id`,`name`,`validation`) VALUES (
        schema_id, @input_types_id, @data_types_id, attribute_name, field_validation
        );

        SET @attributes_id = LAST_INSERT_ID();

        IF attribute_option IS NOT NULL AND attribute_option != '' THEN

          INSERT INTO `attribute_options` (`attributes_id`, `value`) VALUES (@attributes_id, attribute_option);

        END IF;

        IF default_value IS NOT NULL AND default_value != '' THEN

          INSERT INTO `attribute_default_values` (`attributes_id`,`value`) VALUES (@attributes_id, default_value);

        END IF;

      END IF;
    ELSE

		  SET alert_message = "Schema Not Found";

    END IF;

    SET return_id = @attributes_id;

END