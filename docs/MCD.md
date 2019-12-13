```
Producer: siret_number, social reason, address, postal_code, city, email, lastname, firstname, telephone, status, enable, avatar, description
CAN REGISTER AS, 01< User, 11> Producer
Univers: name, image, enable
:

SELL, 0N< Producer, 11> Product
User: email, roles, password, firstname, lastname, telephone, address, postal_code, city, enable
IS CHILD OF, 11< Category, 0N> Univers
Category: name, image, enable

Product: name, price, weight, quantity, image, description, composition, additional_info, allergens, rate, enable
BELONGS TO, 1N< Product, 0N> SubCategory
SubCategory: name, image, enable
RELATED TO, 11< SubCategory, 0N> Category
```

![Conceptual data model](MCD.svg)
