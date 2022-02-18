define({ "api": [{
    "type": "post",
    "url": "/equipment_category/add",
    "title": "Add Equipment category.",
    "version": "0.1.0",
    "name": "Addequipment_category",
    "group": "equipment_category",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment category unique access-key.</p>"
          }
          ,
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment category unique token.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Equipment category Cant be Accessed permission name : api_equipment_category_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Name",
            "description": "<p>Mandatory name of Equipment categorys Input Name Max Length : 512..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Image",
            "description": "<p>Mandatory image of Equipment categorys .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment_category.php",
    "groupTitle": "Equipment category"
  },
  {
    "type": "get",
    "url": "/equipment_category/all",
    "title": "Get all Equipment categorys.",
    "version": "0.1.0",
    "name": "Allequipment_category",
    "group": "equipment_category",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment categorys unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment categorys unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Equipment category_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Equipment categorys.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Equipment categorys.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Equipment categorys.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipment category.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEquipment category",
            "description": "<p>Equipment category data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment category.php",
    "groupTitle": "Equipment category"
  },
  {
    "type": "post",
    "url": "/Equipment category/delete",
    "title": "Delete Equipment category.",
    "version": "0.1.0",
    "name": "Deleteequipment_category",
    "group": "equipment_category",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment categorys unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment categorys unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipment category Cant be Accessed permission name : api_Equipment category_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipment categorys .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment category.php",
    "groupTitle": "Equipment category"
  },
  {
    "type": "get",
    "url": "/Equipment category/detail",
    "title": "Detail Equipment category.",
    "version": "0.1.0",
    "name": "Detailequipment_category",
    "group": "equipment_category",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment categorys unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment categorys unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipment category Cant be Accessed permission name : api_Equipment category_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipment categorys.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipment category.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Equipment categoryNotFound",
            "description": "<p>Equipment category data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment category.php",
    "groupTitle": "Equipment category"
  },
  {
    "type": "post",
    "url": "/Equipment category/update",
    "title": "Update Equipment category.",
    "version": "0.1.0",
    "name": "Updateequipment_category",
    "group": "equipment_category",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment categorys unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment categorys unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipment category Cant be Accessed permission name : api_Equipment category_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Name",
            "description": "<p>Mandatory name of Equipment categorys Input Name Max Length : 512..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Image",
            "description": "<p>Mandatory image of Equipment categorys .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment category.php",
    "groupTitle": "Equipment category"
  },{
    "type": "post",
    "url": "/static_pages/add",
    "title": "Add Static pages.",
    "version": "0.1.0",
    "name": "Addstatic_pages",
    "group": "static_pages",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Static pages unique access-key.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Static pages Cant be Accessed permission name : api_static_pages_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Name",
            "description": "<p>Mandatory name of Static pagess Input Name Max Length : 1024..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Content",
            "description": "<p>Mandatory content of Static pagess .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Static_pages.php",
    "groupTitle": "Static pages"
  },
  {
    "type": "get",
    "url": "/static_pages/all",
    "title": "Get all Static pagess.",
    "version": "0.1.0",
    "name": "Allstatic_pages",
    "group": "static_pages",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Static pagess unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Static pagess unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Static pages_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Static pagess.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Static pagess.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Static pagess.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Static pages.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataStatic pages",
            "description": "<p>Static pages data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Static pages.php",
    "groupTitle": "Static pages"
  },
  {
    "type": "post",
    "url": "/Static pages/delete",
    "title": "Delete Static pages.",
    "version": "0.1.0",
    "name": "Deletestatic_pages",
    "group": "static_pages",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Static pagess unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Static pagess unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Static pages Cant be Accessed permission name : api_Static pages_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Static pagess .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Static pages.php",
    "groupTitle": "Static pages"
  },
  {
    "type": "get",
    "url": "/Static pages/detail",
    "title": "Detail Static pages.",
    "version": "0.1.0",
    "name": "Detailstatic_pages",
    "group": "static_pages",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Static pagess unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Static pagess unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Static pages Cant be Accessed permission name : api_Static pages_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Static pagess.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Static pages.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Static pagesNotFound",
            "description": "<p>Static pages data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Static pages.php",
    "groupTitle": "Static pages"
  }
,
  {
    "type": "post",
    "url": "/Static pages/update",
    "title": "Update Static pages.",
    "version": "0.1.0",
    "name": "Updatestatic_pages",
    "group": "static_pages",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Static pagess unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Static pagess unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Static pages Cant be Accessed permission name : api_Static pages_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Name",
            "description": "<p>Mandatory name of Static pagess Input Name Max Length : 1024..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Content",
            "description": "<p>Mandatory content of Static pagess .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Static pages.php",
    "groupTitle": "Static pages"
  }
,  {
    "type": "get",
    "url": "/equipments_available/all",
    "title": "Get all Equipments availables.",
    "version": "0.1.0",
    "name": "Allequipments_available",
    "group": "equipments_available",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipments availables unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipments availables unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Equipments available_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Equipments availables.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Equipments availables.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Equipments availables.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipments available.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEquipments available",
            "description": "<p>Equipments available data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments available.php",
    "groupTitle": "Equipments available"
  },
  {
    "type": "get",
    "url": "/Equipments available/detail",
    "title": "Detail Equipments available.",
    "version": "0.1.0",
    "name": "Detailequipments_available",
    "group": "equipments_available",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipments availables unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipments availables unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipments available Cant be Accessed permission name : api_Equipments available_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipments availables.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipments available.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Equipments availableNotFound",
            "description": "<p>Equipments available data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments available.php",
    "groupTitle": "Equipments available"
  }
,{
    "type": "post",
    "url": "/events/add",
    "title": "Add Events.",
    "version": "0.1.0",
    "name": "Addevents",
    "group": "events",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events unique access-key.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Events Cant be Accessed permission name : api_events_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_name",
            "description": "<p>Mandatory event_name of Eventss Input Event Name Max Length : 2048..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_type",
            "description": "<p>Mandatory event_type of Eventss Input Event Type Max Length : 128..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_location",
            "description": "<p>Mandatory event_location of Eventss Input Event Location Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Check_in_date",
            "description": "<p>Optional check_in_date of Eventss .</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Check_out_date",
            "description": "<p>Optional check_out_date of Eventss .</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Event_image",
            "description": "<p>Optional event_image of Eventss .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events.php",
    "groupTitle": "Events"
  },
  {
    "type": "get",
    "url": "/events/all",
    "title": "Get all Eventss.",
    "version": "0.1.0",
    "name": "Allevents",
    "group": "events",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Eventss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Eventss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Events_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Eventss.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Eventss.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Eventss.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEvents",
            "description": "<p>Events data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events.php",
    "groupTitle": "Events"
  },
  {
    "type": "post",
    "url": "/Events/delete",
    "title": "Delete Events.",
    "version": "0.1.0",
    "name": "Deleteevents",
    "group": "events",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Eventss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Eventss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Events Cant be Accessed permission name : api_Events_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Eventss .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events.php",
    "groupTitle": "Events"
  },
  {
    "type": "get",
    "url": "/Events/detail",
    "title": "Detail Events.",
    "version": "0.1.0",
    "name": "Detailevents",
    "group": "events",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Eventss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Eventss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Events Cant be Accessed permission name : api_Events_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Eventss.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EventsNotFound",
            "description": "<p>Events data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events.php",
    "groupTitle": "Events"
  },
  {
    "type": "post",
    "url": "/Events/update",
    "title": "Update Events.",
    "version": "0.1.0",
    "name": "Updateevents",
    "group": "events",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Eventss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Eventss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Events Cant be Accessed permission name : api_Events_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_name",
            "description": "<p>Mandatory event_name of Eventss Input Event Name Max Length : 2048..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_type",
            "description": "<p>Mandatory event_type of Eventss Input Event Type Max Length : 128..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_location",
            "description": "<p>Mandatory event_location of Eventss Input Event Location Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Check_in_date",
            "description": "<p>Optional check_in_date of Eventss .</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Check_out_date",
            "description": "<p>Optional check_out_date of Eventss .</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Event_image",
            "description": "<p>Optional event_image of Eventss .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events.php",
    "groupTitle": "Events"
  },{
    "type": "post",
    "url": "/user/signup",
    "title": "User Signup",
    "version": "0.1.0",
    "name": "SignupUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          }
        ]
      }
    },
    "permission": [
    ],
   "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>Mandatory email of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": "<p>password of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_name",
            "description": "<p>Full name of User.</p>"
          }
       ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
     },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
}, 
{
    "type": "post",
    "url": "/user/add",
    "title": "Add User.",
    "version": "0.1.0",
    "name": "AddUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_name",
            "description": "<p>Mandatory Full Name of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>Mandatory email of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": "<p>password of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": true,
            "field": "Group",
            "defaultValue": "Default",
            "description": "<p>Optional group of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "Avatar",
            "defaultValue": "Default.PNG",
            "description": "<p>Optional avatar of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/all",
    "title": "Get all users.",
    "version": "0.1.0",
    "name": "AllUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Filter",
            "defaultValue": "null",
            "description": "<p>Optional filter of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of user.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataUser",
            "description": "<p>User data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/delete",
    "title": "Delete User.",
    "version": "0.1.0",
    "name": "DeleteUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>mandatory id of Users .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/detail",
    "title": "Detail User.",
    "version": "0.1.0",
    "name": "DetailUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of user.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>User data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/login",
    "title": "User login authentication.",
    "version": "0.1.0",
    "name": "LoginUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>Mandatory email of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": "<p>Mandatory password of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of user.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>token for access api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidCredential",
            "description": "<p>The email or password is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/request_token",
    "title": "User request token.",
    "version": "0.1.0",
    "name": "RequestTokenUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>Mandatory eamil of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": "<p>Mandatory password of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>token for access api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidCredential",
            "description": "<p>The username or password is invalid.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/profile",
    "title": "Profile User.",
    "version": "0.1.0",
    "name": "ProfileUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_profile"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of user.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>User data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/update_profile",
    "title": "Update Profile User.",
    "version": "0.1.0",
    "name": "UpdateProfileUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>Mandatory email of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": "<p>password of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": true,
            "field": "Group",
            "defaultValue": "Default",
            "description": "<p>Optional group of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "Avatar",
            "defaultValue": "Default.PNG",
            "description": "<p>Optional avatar of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>id of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/update",
    "title": "Update User.",
    "version": "0.1.0",
    "name": "UpdateUser",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Users unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Users unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_user_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Email",
            "description": "<p>Mandatory email of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Password",
            "description": "<p>password of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": true,
            "field": "Group",
            "defaultValue": "Default",
            "description": "<p>Optional group of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "Avatar",
            "defaultValue": "Default.PNG",
            "description": "<p>Optional avatar of Users.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Users.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/User.php",
    "groupTitle": "User"
  }
,  {
    "type": "get",
    "url": "/events_future/all",
    "title": "Get all Events futures.",
    "version": "0.1.0",
    "name": "Allevents_future",
    "group": "events_future",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events futures unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Events futures unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Events future_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Events futures.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Events futures.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Events futures.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events future.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEvents future",
            "description": "<p>Events future data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events future.php",
    "groupTitle": "Events future"
  },
  {
    "type": "get",
    "url": "/Events future/detail",
    "title": "Detail Events future.",
    "version": "0.1.0",
    "name": "Detailevents_future",
    "group": "events_future",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events futures unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Events futures unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Events future Cant be Accessed permission name : api_Events future_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Events futures.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events future.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Events futureNotFound",
            "description": "<p>Events future data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events future.php",
    "groupTitle": "Events future"
  }
,  {
    "type": "get",
    "url": "/events_past/all",
    "title": "Get all Events pasts.",
    "version": "0.1.0",
    "name": "Allevents_past",
    "group": "events_past",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events pasts unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Events pasts unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Events past_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Events pasts.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Events pasts.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Events pasts.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events past.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEvents past",
            "description": "<p>Events past data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events past.php",
    "groupTitle": "Events past"
  },
  {
    "type": "get",
    "url": "/Events past/detail",
    "title": "Detail Events past.",
    "version": "0.1.0",
    "name": "Detailevents_past",
    "group": "events_past",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events pasts unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Events pasts unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Events past Cant be Accessed permission name : api_Events past_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Events pasts.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events past.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Events pastNotFound",
            "description": "<p>Events past data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events past.php",
    "groupTitle": "Events past"
  }
,{
    "type": "post",
    "url": "/event_equipment_checkout/add",
    "title": "Add Event equipment checkout.",
    "version": "0.1.0",
    "name": "Addevent_equipment_checkout",
    "group": "event_equipment_checkout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checkout unique access-key.</p>"
          }
          ,
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checkout unique token.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checkout Cant be Accessed permission name : api_event_equipment_checkout_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_id",
            "description": "<p>Mandatory event_id of Event equipment checkouts Input Event Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_id",
            "description": "<p>Mandatory equipment_id of Event equipment checkouts Input Equipment Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_out_datetime",
            "description": "<p>Optional equipment_out_datetime of Event equipment checkouts .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event_equipment_checkout.php",
    "groupTitle": "Event equipment checkout"
  },
  {
    "type": "get",
    "url": "/event_equipment_checkout/all",
    "title": "Get all Event equipment checkouts.",
    "version": "0.1.0",
    "name": "Allevent_equipment_checkout",
    "group": "event_equipment_checkout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checkouts unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checkouts unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Event equipment checkout_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Event equipment checkouts.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Event equipment checkouts.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Event equipment checkouts.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Event equipment checkout.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEvent equipment checkout",
            "description": "<p>Event equipment checkout data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checkout.php",
    "groupTitle": "Event equipment checkout"
  },
  {
    "type": "post",
    "url": "/Event equipment checkout/delete",
    "title": "Delete Event equipment checkout.",
    "version": "0.1.0",
    "name": "Deleteevent_equipment_checkout",
    "group": "event_equipment_checkout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checkouts unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checkouts unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checkout Cant be Accessed permission name : api_Event equipment checkout_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Event equipment checkouts .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checkout.php",
    "groupTitle": "Event equipment checkout"
  },
  {
    "type": "get",
    "url": "/Event equipment checkout/detail",
    "title": "Detail Event equipment checkout.",
    "version": "0.1.0",
    "name": "Detailevent_equipment_checkout",
    "group": "event_equipment_checkout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checkouts unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checkouts unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checkout Cant be Accessed permission name : api_Event equipment checkout_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Event equipment checkouts.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Event equipment checkout.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Event equipment checkoutNotFound",
            "description": "<p>Event equipment checkout data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checkout.php",
    "groupTitle": "Event equipment checkout"
  },
  {
    "type": "post",
    "url": "/Event equipment checkout/update",
    "title": "Update Event equipment checkout.",
    "version": "0.1.0",
    "name": "Updateevent_equipment_checkout",
    "group": "event_equipment_checkout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checkouts unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checkouts unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checkout Cant be Accessed permission name : api_Event equipment checkout_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_id",
            "description": "<p>Mandatory event_id of Event equipment checkouts Input Event Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_id",
            "description": "<p>Mandatory equipment_id of Event equipment checkouts Input Equipment Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_out_datetime",
            "description": "<p>Optional equipment_out_datetime of Event equipment checkouts .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checkout.php",
    "groupTitle": "Event equipment checkout"
  }, {
    "type": "post",
    "url": "/group/add",
    "title": "Add Group.",
    "version": "0.1.0",
    "name": "AddGroup",
    "group": "Group",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Groups unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Groups unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_group_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Name",
            "description": "<p>Mandatory name of Groups.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Definition",
            "description": "<p>Optional definition of Groups.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Group.php",
    "groupTitle": "Group"
  },
  {
    "type": "get",
    "url": "/group/all",
    "title": "Get all groups.",
    "version": "0.1.0",
    "name": "AllGroup",
    "group": "Group",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Groups unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Groups unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_group_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Filter",
            "defaultValue": "null",
            "description": "<p>Optional filter of Groups.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Groups.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Groups.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Groups.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of group.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataGroup",
            "description": "<p>Group data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Group.php",
    "groupTitle": "Group"
  },
  {
    "type": "post",
    "url": "/group/delete",
    "title": "Delete Group.",
    "version": "0.1.0",
    "name": "DeleteGroup",
    "group": "Group",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Groups unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Groups unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_group_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Groups .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Group.php",
    "groupTitle": "Group"
  },
  {
    "type": "get",
    "url": "/group/detail",
    "title": "Detail Group.",
    "version": "0.1.0",
    "name": "DetailGroup",
    "group": "Group",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Groups unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Groups unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_group_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Groups.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of group.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "GroupNotFound",
            "description": "<p>Group data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Group.php",
    "groupTitle": "Group"
  },
  {
    "type": "post",
    "url": "/group/update",
    "title": "Update Group.",
    "version": "0.1.0",
    "name": "UpdateGroup",
    "group": "Group",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-API-KEY",
            "description": "<p>Groups unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Groups unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Group Cant be Accessed permission name : api_group_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Name",
            "description": "<p>Mandatory Name of Groups.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Definition",
            "description": "<p>Optional definition of Groups.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Group.php",
    "groupTitle": "Group"
  },  {
    "type": "get",
    "url": "/equipments_not_available/all",
    "title": "Get all Equipments not availables.",
    "version": "0.1.0",
    "name": "Allequipments_not_available",
    "group": "equipments_not_available",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipments not availables unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipments not availables unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Equipments not available_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Equipments not availables.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Equipments not availables.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Equipments not availables.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipments not available.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEquipments not available",
            "description": "<p>Equipments not available data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments not available.php",
    "groupTitle": "Equipments not available"
  },
  {
    "type": "get",
    "url": "/Equipments not available/detail",
    "title": "Detail Equipments not available.",
    "version": "0.1.0",
    "name": "Detailequipments_not_available",
    "group": "equipments_not_available",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipments not availables unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipments not availables unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipments not available Cant be Accessed permission name : api_Equipments not available_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipments not availables.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipments not available.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Equipments not availableNotFound",
            "description": "<p>Equipments not available data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments not available.php",
    "groupTitle": "Equipments not available"
  }
,{
    "type": "post",
    "url": "/equipments/add",
    "title": "Add Equipments.",
    "version": "0.1.0",
    "name": "Addequipments",
    "group": "equipments",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipments unique access-key.</p>"
          }
          ,
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipments unique token.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Equipments Cant be Accessed permission name : api_equipments_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_name",
            "description": "<p>Mandatory equipment_name of Equipmentss Input Equipment Name Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_condition",
            "description": "<p>Mandatory equipment_condition of Equipmentss Input Equipment Condition Max Length : 100, In List : OLD,NEW,BAD,FAIR..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_size",
            "description": "<p>Mandatory equipment_size of Equipmentss Input Equipment Size Max Length : 100, In List : LONG,VERY LONG,SHORT,VERY SHORT,NA..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_description",
            "description": "<p>Optional equipment_description of Equipmentss Input Equipment Description Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_barcode",
            "description": "<p>Optional equipment_barcode of Equipmentss Input Equipment Barcode Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_category_id",
            "description": "<p>Mandatory equipment_category_id of Equipmentss Input Equipment Category Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_image",
            "description": "<p>Optional equipment_image of Equipmentss .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments.php",
    "groupTitle": "Equipments"
  },
  {
    "type": "get",
    "url": "/equipments/all",
    "title": "Get all Equipmentss.",
    "version": "0.1.0",
    "name": "Allequipments",
    "group": "equipments",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipmentss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipmentss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Equipments_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Equipmentss.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Equipmentss.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Equipmentss.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipments.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEquipments",
            "description": "<p>Equipments data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments.php",
    "groupTitle": "Equipments"
  },
  {
    "type": "post",
    "url": "/Equipments/delete",
    "title": "Delete Equipments.",
    "version": "0.1.0",
    "name": "Deleteequipments",
    "group": "equipments",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipmentss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipmentss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipments Cant be Accessed permission name : api_Equipments_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipmentss .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments.php",
    "groupTitle": "Equipments"
  },
  {
    "type": "get",
    "url": "/Equipments/detail",
    "title": "Detail Equipments.",
    "version": "0.1.0",
    "name": "Detailequipments",
    "group": "equipments",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipmentss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipmentss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipments Cant be Accessed permission name : api_Equipments_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipmentss.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipments.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EquipmentsNotFound",
            "description": "<p>Equipments data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments.php",
    "groupTitle": "Equipments"
  },
  {
    "type": "post",
    "url": "/Equipments/update",
    "title": "Update Equipments.",
    "version": "0.1.0",
    "name": "Updateequipments",
    "group": "equipments",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipmentss unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipmentss unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipments Cant be Accessed permission name : api_Equipments_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_name",
            "description": "<p>Mandatory equipment_name of Equipmentss Input Equipment Name Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_condition",
            "description": "<p>Mandatory equipment_condition of Equipmentss Input Equipment Condition Max Length : 100, In List : OLD,NEW,BAD,FAIR..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_size",
            "description": "<p>Mandatory equipment_size of Equipmentss Input Equipment Size Max Length : 100, In List : LONG,VERY LONG,SHORT,VERY SHORT,NA..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_description",
            "description": "<p>Optional equipment_description of Equipmentss Input Equipment Description Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_barcode",
            "description": "<p>Optional equipment_barcode of Equipmentss Input Equipment Barcode Max Length : 4096..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_category_id",
            "description": "<p>Mandatory equipment_category_id of Equipmentss Input Equipment Category Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_image",
            "description": "<p>Optional equipment_image of Equipmentss .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipments.php",
    "groupTitle": "Equipments"
  },{
    "type": "post",
    "url": "/equipment_checkin/add",
    "title": "Add Equipment checkin.",
    "version": "0.1.0",
    "name": "Addequipment_checkin",
    "group": "equipment_checkin",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment checkin unique access-key.</p>"
          }
          ,
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment checkin unique token.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Equipment checkin Cant be Accessed permission name : api_equipment_checkin_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_id",
            "description": "<p>Mandatory equipment_id of Equipment checkins Input Equipment Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_in_datetime",
            "description": "<p>Optional equipment_in_datetime of Equipment checkins .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment_checkin.php",
    "groupTitle": "Equipment checkin"
  },
  {
    "type": "get",
    "url": "/equipment_checkin/all",
    "title": "Get all Equipment checkins.",
    "version": "0.1.0",
    "name": "Allequipment_checkin",
    "group": "equipment_checkin",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment checkins unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment checkins unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Equipment checkin_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Equipment checkins.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Equipment checkins.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Equipment checkins.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipment checkin.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEquipment checkin",
            "description": "<p>Equipment checkin data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment checkin.php",
    "groupTitle": "Equipment checkin"
  },
  {
    "type": "post",
    "url": "/Equipment checkin/delete",
    "title": "Delete Equipment checkin.",
    "version": "0.1.0",
    "name": "Deleteequipment_checkin",
    "group": "equipment_checkin",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment checkins unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment checkins unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipment checkin Cant be Accessed permission name : api_Equipment checkin_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipment checkins .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment checkin.php",
    "groupTitle": "Equipment checkin"
  },
  {
    "type": "get",
    "url": "/Equipment checkin/detail",
    "title": "Detail Equipment checkin.",
    "version": "0.1.0",
    "name": "Detailequipment_checkin",
    "group": "equipment_checkin",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment checkins unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment checkins unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipment checkin Cant be Accessed permission name : api_Equipment checkin_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Equipment checkins.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Equipment checkin.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Equipment checkinNotFound",
            "description": "<p>Equipment checkin data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment checkin.php",
    "groupTitle": "Equipment checkin"
  },
  {
    "type": "post",
    "url": "/Equipment checkin/update",
    "title": "Update Equipment checkin.",
    "version": "0.1.0",
    "name": "Updateequipment_checkin",
    "group": "equipment_checkin",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Equipment checkins unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Equipment checkins unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Equipment checkin Cant be Accessed permission name : api_Equipment checkin_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_id",
            "description": "<p>Mandatory equipment_id of Equipment checkins Input Equipment Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Equipment_in_datetime",
            "description": "<p>Optional equipment_in_datetime of Equipment checkins .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Equipment checkin.php",
    "groupTitle": "Equipment checkin"
  },  {
    "type": "get",
    "url": "/events_ongoing/all",
    "title": "Get all Events ongoings.",
    "version": "0.1.0",
    "name": "Allevents_ongoing",
    "group": "events_ongoing",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events ongoings unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Events ongoings unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Events ongoing_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Events ongoings.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Events ongoings.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Events ongoings.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events ongoing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEvents ongoing",
            "description": "<p>Events ongoing data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events ongoing.php",
    "groupTitle": "Events ongoing"
  },
  {
    "type": "get",
    "url": "/Events ongoing/detail",
    "title": "Detail Events ongoing.",
    "version": "0.1.0",
    "name": "Detailevents_ongoing",
    "group": "events_ongoing",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Events ongoings unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Events ongoings unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Events ongoing Cant be Accessed permission name : api_Events ongoing_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Events ongoings.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Events ongoing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Events ongoingNotFound",
            "description": "<p>Events ongoing data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Events ongoing.php",
    "groupTitle": "Events ongoing"
  }
,{
    "type": "post",
    "url": "/event_equipment_checklist/add",
    "title": "Add Event equipment checklist.",
    "version": "0.1.0",
    "name": "Addevent_equipment_checklist",
    "group": "event_equipment_checklist",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checklist unique access-key.</p>"
          }
          ,
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checklist unique token.</p>"
          }
                  ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checklist Cant be Accessed permission name : api_event_equipment_checklist_add"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_id",
            "description": "<p>Mandatory event_id of Event equipment checklists Input Event Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_id",
            "description": "<p>Mandatory equipment_id of Event equipment checklists Input Equipment Id Max Length : 11..</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event_equipment_checklist.php",
    "groupTitle": "Event equipment checklist"
  },
  {
    "type": "get",
    "url": "/event_equipment_checklist/all",
    "title": "Get all Event equipment checklists.",
    "version": "0.1.0",
    "name": "Allevent_equipment_checklist",
    "group": "event_equipment_checklist",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checklists unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checklists unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "{} Cant be Accessed permission name : api_Event equipment checklist_all"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
         
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Field",
            "defaultValue": "All Field",
            "description": "<p>Optional field of Event equipment checklists.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Start",
            "defaultValue": "0",
            "description": "<p>Optional start index of Event equipment checklists.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "Limit",
            "defaultValue": "10",
            "description": "<p>Optional limit data of Event equipment checklists.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Event equipment checklist.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "NoDataEvent equipment checklist",
            "description": "<p>Event equipment checklist data is nothing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checklist.php",
    "groupTitle": "Event equipment checklist"
  },
  {
    "type": "post",
    "url": "/Event equipment checklist/delete",
    "title": "Delete Event equipment checklist.",
    "version": "0.1.0",
    "name": "Deleteevent_equipment_checklist",
    "group": "event_equipment_checklist",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checklists unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checklists unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checklist Cant be Accessed permission name : api_Event equipment checklist_delete"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Event equipment checklists .</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checklist.php",
    "groupTitle": "Event equipment checklist"
  },
  {
    "type": "get",
    "url": "/Event equipment checklist/detail",
    "title": "Detail Event equipment checklist.",
    "version": "0.1.0",
    "name": "Detailevent_equipment_checklist",
    "group": "event_equipment_checklist",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checklists unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checklists unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checklist Cant be Accessed permission name : api_Event equipment checklist_detail"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "Id",
            "description": "<p>Mandatory id of Event equipment checklists.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "Data",
            "description": "<p>data of Event equipment checklist.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Event equipment checklistNotFound",
            "description": "<p>Event equipment checklist data is not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checklist.php",
    "groupTitle": "Event equipment checklist"
  },
  {
    "type": "post",
    "url": "/Event equipment checklist/update",
    "title": "Update Event equipment checklist.",
    "version": "0.1.0",
    "name": "Updateevent_equipment_checklist",
    "group": "event_equipment_checklist",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Api-Key",
            "description": "<p>Event equipment checklists unique access-key.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-Token",
            "description": "<p>Event equipment checklists unique token.</p>"
          }
        ]
      }
    },
    "permission": [
      {
        "name": "Event equipment checklist Cant be Accessed permission name : api_Event equipment checklist_update"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
                    {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Event_id",
            "description": "<p>Mandatory event_id of Event equipment checklists Input Event Id Max Length : 11..</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Equipment_id",
            "description": "<p>Mandatory equipment_id of Event equipment checklists Input Equipment Id Max Length : 11..</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "Status",
            "description": "<p>status response api.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Message",
            "description": "<p>message response api.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ValidationError",
            "description": "<p>Error validation.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 403 Not Acceptable",
          "type": "json"
        }
      ]
    },
    "filename": "application/controllers/api/Event equipment checklist.php",
    "groupTitle": "Event equipment checklist"
  }] });
