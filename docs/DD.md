# Data dictionary

## Users (`user`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the customer|
|email|VARCHAR(180)|NOT NULL, UNIQUE|The email associated to the user|
|roles|JSON|NOT NULL|All roles assigned to the user|
|password|VARCHAR(255)|NOT NULL|The password hash used to login to the account|
|firstname|VARCHAR(20)|NULL|The firstname of the customer|
|lastname|VARCHAR(20)|NULL|The lastname of the customer|
|telephone|VARCHAR(14)|NULL|Telephone number of the customer|
|address|VARCHAR(64)|NULL|Delivery address of the user|
|postal_code|INT(11)|NULL, UNSIGNED|Postal code according to the user|
|city|VARCHAR(50)|NULL|Housing city of the user|
|enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the user account is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the user account|
|updated_at|DATETIME|NULL|The last update of the user profile|

## Producers (`producer`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the producer|
|user_id|INT(11)|FOREIGN KEY, UNSIGNED, NOT NULL|User id attached to the producer|
|social_reason|VARCHAR(64)|NOT NULL|The name of the company|
|siret_number|VARCHAR(255)|NOT NULL|The number proving the authenticity of the producer's activity|
|address|VARCHAR(64)|NOT NULL|The address of the producer|
|postal_code|VARCHAR(5)|NOT NULL|The postal code according to the city|
|city|VARCHAR(50)|NOT NULL|The city of the producer|
|email|VARCHAR(180)|NOT NULL|Email address of the producer|
|firstname|VARCHAR(20)|NOT NULL|The firstname of the producer|
|lastname|VARCHAR(20)|NOT NULL|The lastname of the producer|
|telephone|VARCHAR(21)|NOT NULL|Telephone number of the producer|
|status|VARCHAR(64)|NULL|The status of the producer|
|enable|TINYINT(1)|NOT NULL, DEFAULT 0|Set if access to the producer is restricted|
|avatar|VARCHAR(255)|NULL|The profile picture of the producer|
|description|LONGTEXT|NULL|The description of the producer|
|created_at|DATETIME|NOT NULL|The creation date of the producer profile|
|updated_at|DATETIME|NULL|The last update of the producer profile|

## Products (`product`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the product|
|producer_id|INT(11)|FOREIGN KEY, NOT NULL, UNSIGNED|Producer id attached to the product|
|name|VARCHAR(64)|NOT NULL|The name of the product|
|price|DECIMAL(8,3)|NOT NULL, UNSIGNED|The price for a single unit of the product|
|weight|INT(11)|NOT NULL, UNSIGNED|The weight for a single unit of the product|
|quantity|INT(11)|NOT NULL, UNSIGNED|The total quantity of products on sale|
|image|VARCHAR(255)|NULL|The image of the product|
|description|LONGTEXT|NULL|The description of the product|
|composition|LONGTEXT|NULL|The ingredients contained in the product|
|additional_info|LONGTEXT|NULL|Additional information about the product|
|allergens|LONGTEXT|NULL|The allergens present in the product|
|rate|INT(11)|NOT NULL, DEFAULT 0|Customer reviews on the product|
|enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the product is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the product|
|updated_at|DATETIME|NULL|The last update of the product|  

## Products - Subcategories (`product_subcategory`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|product_id|INT(11)|PRIMARY KEY, FOREIGN KEY, NOT NULL, UNSIGNED|The identifier related to the product|
|subcategory_id|INT(11)|PRIMARY KEY, FOREIGN KEY, NOT NULL, UNSIGNED|The identifier related to the subcategory|

## Subcategories (`subcategory`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the subcategory|
|category_id|INT(11)|FOREIGN KEY, NOT NULL, UNSIGNED|Category id related to the subcategory|
|name|VARCHAR(64)|NOT NULL|The name of the subcategory|
|image|VARCHAR(255)|NULL|The image displayed on subcategory page|
|enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the subcategory is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the subcategory|
|updated_at|DATETIME|NULL|The last update of the subcategory|

## Categories (`category`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the category|
|univers_id|INT(11)|FOREIGN KEY, NOT NULL, UNSIGNED|Univers id related to the category|
|name|VARCHAR(64)|NOT NULL|The name of the category|
|image|VARCHAR(255)|NULL|The image displayed on category page|
|enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the category is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the category|
|updated_at|DATETIME|NULL|The last update of the category|

## Univers (`univers`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the univers|
|name|VARCHAR(64)|NOT NULL|The name of the univers|
|image|VARCHAR(255)|NULL|The image displayed on univers page|
|enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the univers is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the univers|
|updated_at|DATETIME|NULL|The last update of the univers|
