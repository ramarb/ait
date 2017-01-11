[
    {
        "attribute_name" : "nid",
        "label":"NID",
        "Description":"The Rela defined id representing the property",
        "access":"read|write",
        "input_type":"text",
        "data_type":"string",
        "validation":"",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "created",
        "label":"Date Created",
        "Description":"The time the property was added to Rela",
        "access":"read|write",
        "input_type":"text",
        "data_type":"timestamp",
        "validation":"",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "changed",
        "label":"Date Changed",
        "Description":"The time the property was last changed",
        "access":"read|write",
        "input_type":"text",
        "data_type":"timestamp",
        "validation":"",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "title",
        "label":"Title",
        "Description":"The title of the property",
        "access":"read|write",
        "input_type":"text",
        "data_type":"string",
        "validation":"",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "file",
        "label":"File",
        "Description":"Contains the file data, Base64 encoded image data",
        "access":"read|write",
        "input_type":"text",
        "data_type":"blob",
        "validation":"required",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "file_name",
        "label":"Filename",
        "Description":"Name of the image file including extension",
        "access":"read|write",
        "input_type":"text",
        "data_type":"string",
        "validation":"required",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "property_reference",
        "label":"Property Reference",
        "Description":"Rela nid of Property to add image to",
        "access":"read|write",
        "input_type":"text",
        "data_type":"int",
        "validation":"required",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "main_image",
        "label":"Main Image",
        "Description":"Set this image as the main image",
        "access":"read|write",
        "input_type":"text",
        "data_type":"bool",
        "validation":"",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "description",
        "label":"Description",
        "Description":"Description of the image",
        "access":"read|write",
        "input_type":"text",
        "data_type":"string",
        "validation":"",
        "option":"",
        "default":""
    },
    {
        "attribute_name" : "date_taken",
        "label":"Date Taken",
        "Description":"Original date taken in UNIX timestamp",
        "access":"read|write",
        "input_type":"text",
        "data_type":"timestamp",
        "validation":"",
        "option":"",
        "default":""
    }
]
