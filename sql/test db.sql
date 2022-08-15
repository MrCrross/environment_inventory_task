use equipment_inventory;
create table if not exists categories
(
    id         bigint unsigned not null primary key auto_increment,
    name       varchar(255)    not null unique,
    created_at timestamp default now(),
    updated_at timestamp default now()
);

create table if not exists equipments
(
    id          bigint unsigned  not null primary key auto_increment,
    name        varchar(255)     not null unique,
    price       integer unsigned not null default 0,
    category_id bigint unsigned  not null,
    created_at  timestamp                 default now(),
    updated_at  timestamp                 default now(),
    deleted_at  timestamp                 DEFAULT null,
    foreign key (category_id) references categories (id) on delete restrict

);

create table if not exists users
(
    id         bigint unsigned not null primary key auto_increment,
    name       varchar(255)    not null unique,
    password   varchar(255)    not null,
    created_at timestamp default now(),
    updated_at timestamp default now(),
    deleted_at timestamp DEFAULT null
);

create table if not exists arrival
(
    id             bigint unsigned  not null primary key auto_increment,
    equipment_id bigint unsigned  not null,
    user_id        bigint unsigned  not null,
    count          integer unsigned not null,
    arrival        datetime         not null default now(),
    created_at     timestamp default now(),
    updated_at     timestamp default now(),
    deleted_at timestamp DEFAULT null,
    foreign key (equipment_id) references equipments (id),
    foreign key (user_id) references users (id)
);

insert into users (name, password)
values ('admin', 'c9fe854ea69fc0a252340e152864b539b116c36cf1ac419652e1826c3071d5ed'),
       ('user', 'c9fe854ea69fc0a252340e152864b539b116c36cf1ac419652e1826c3071d5ed'),
       ('manager', 'c9fe854ea69fc0a252340e152864b539b116c36cf1ac419652e1826c3071d5ed');
insert
into categories (name)
values ('Наушники'),
       ('Телефон'),
       ('Стол');
insert into equipments (name, price, category_id)
values ('Наушники 1', 1000, 1),
       ('Телефон Xiaomi', 10000, 2),
       ('Стол Versace', 99999, 3);
insert into arrival (equipment_id, user_id, count)
values (1, 1, 10),
       (2, 2, 5),
       (3, 3, 299);