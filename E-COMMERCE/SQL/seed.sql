insert into ecommerce.products(nome, prezzo, marca)
values ("Cuffie GHX 99", 299.99, "Rossi - SRL"),
       ("Lanzichenecchi", 599.99, "HRE"),
       ("Manuel Cecchetto", 5.99, "Villadose"),
       ("PC", 459.99, "Henry&Ale"),

insert into ecommerce.roles(nome, descrizione)
values
    ("shopper", "utente base"), ("admin", "utente privilegiato");

insert into ecommerce.users(email, password, role_id)
values ('todirascu@gmail.com', SHA2('password123', 256), 1),
       ('pilotto@gmail.com', SHA2('qwerty456', 256), 1),
       ('ghirardello@outlook.com', SHA2('letmein789', 256), 1),
       ('alberto@libero.it', SHA2('pass1234', 256), 2);