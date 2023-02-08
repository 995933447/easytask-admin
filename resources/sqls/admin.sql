create table admin_menu
(
    id         int unsigned auto_increment
        primary key,
    parent_id  int default 0 not null,
    `order`    int default 0 not null,
    title      varchar(50)   not null,
    icon       varchar(50)   not null,
    uri        varchar(255)  null,
    permission varchar(255)  null,
    created_at timestamp     null,
    updated_at timestamp     null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (1, 0, 1, 'Dashboard', 'fa-bar-chart', '/', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (2, 0, 2, 'Admin', 'fa-tasks', '', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (3, 2, 3, 'Users', 'fa-users', 'auth/users', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (4, 2, 4, 'Roles', 'fa-user', 'auth/roles', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (5, 2, 5, 'Permission', 'fa-ban', 'auth/permissions', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (6, 2, 6, 'Menu', 'fa-bars', 'auth/menu', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (7, 2, 7, 'Operation log', 'fa-history', 'auth/logs', null, null, null);
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (8, 0, 0, 'callback servers', 'fa-bars', '/task-callback-srvs', null, '2023-02-07 18:57:45', '2023-02-07 18:57:45');
INSERT INTO admin_menu (id, parent_id, `order`, title, icon, uri, permission, created_at, updated_at) VALUES (9, 0, 0, 'tasks', 'fa-bars', '/tasks', null, '2023-02-07 18:57:57', '2023-02-07 18:57:57');
create table admin_operation_log
(
    id         int unsigned auto_increment
        primary key,
    user_id    int          not null,
    path       varchar(255) not null,
    method     varchar(10)  not null,
    ip         varchar(255) not null,
    input      text         not null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index admin_operation_log_user_id_index
    on admin_operation_log (user_id);

create table admin_permissions
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(50)  not null,
    slug        varchar(50)  not null,
    http_method varchar(255) null,
    http_path   text         null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    constraint admin_permissions_name_unique
        unique (name),
    constraint admin_permissions_slug_unique
        unique (slug)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO admin_permissions (id, name, slug, http_method, http_path, created_at, updated_at) VALUES (1, 'All permission', '*', '', '*', null, null);
INSERT INTO admin_permissions (id, name, slug, http_method, http_path, created_at, updated_at) VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', null, null);
INSERT INTO admin_permissions (id, name, slug, http_method, http_path, created_at, updated_at) VALUES (3, 'Login', 'auth.login', '', '/auth/login
/auth/logout', null, null);
INSERT INTO admin_permissions (id, name, slug, http_method, http_path, created_at, updated_at) VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', null, null);
INSERT INTO admin_permissions (id, name, slug, http_method, http_path, created_at, updated_at) VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles
/auth/permissions
/auth/menu
/auth/logs', null, null);

create table admin_role_menu
(
    role_id    int       not null,
    menu_id    int       not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create index admin_role_menu_role_id_menu_id_index
    on admin_role_menu (role_id, menu_id);

INSERT INTO admin_role_menu (role_id, menu_id, created_at, updated_at) VALUES (1, 2, null, null);
create table admin_role_permissions
(
    role_id       int       not null,
    permission_id int       not null,
    created_at    timestamp null,
    updated_at    timestamp null
)
    collate = utf8mb4_unicode_ci;

create index admin_role_permissions_role_id_permission_id_index
    on admin_role_permissions (role_id, permission_id);

INSERT INTO admin_role_permissions (role_id, permission_id, created_at, updated_at) VALUES (1, 1, null, null);
create table admin_role_users
(
    role_id    int       not null,
    user_id    int       not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create index admin_role_users_role_id_user_id_index
    on admin_role_users (role_id, user_id);

INSERT INTO admin_role_users (role_id, user_id, created_at, updated_at) VALUES (1, 1, null, null);
create table admin_roles
(
    id         int unsigned auto_increment
        primary key,
    name       varchar(50) not null,
    slug       varchar(50) not null,
    created_at timestamp   null,
    updated_at timestamp   null,
    constraint admin_roles_name_unique
        unique (name),
    constraint admin_roles_slug_unique
        unique (slug)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO admin_roles (id, name, slug, created_at, updated_at) VALUES (1, 'Administrator', 'administrator', '2023-02-01 18:56:58', '2023-02-01 18:56:58');
create table admin_user_permissions
(
    user_id       int       not null,
    permission_id int       not null,
    created_at    timestamp null,
    updated_at    timestamp null
)
    collate = utf8mb4_unicode_ci;

create index admin_user_permissions_user_id_permission_id_index
    on admin_user_permissions (user_id, permission_id);

create table admin_users
(
    id             int unsigned auto_increment
        primary key,
    username       varchar(190) not null,
    password       varchar(60)  not null,
    name           varchar(255) not null,
    avatar         varchar(255) null,
    remember_token varchar(100) null,
    created_at     timestamp    null,
    updated_at     timestamp    null,
    constraint admin_users_username_unique
        unique (username)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO admin_users (id, username, password, name, avatar, remember_token, created_at, updated_at) VALUES (1, 'admin', '$2y$10$N9ZCpkFtrzF9uv6n9UWa.OUAz6qs/uS.s3hmvxJ65Aex0tWi99gXW', 'Administrator', null, 'WCHkealhL3Z4QZWj0dUe9lJIgFnZOunfpYFQ7Ia4YgtFeeCo3397CD9DpGI0', '2023-02-01 18:56:58', '2023-02-01 18:56:58');
create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;


create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO migrations (id, migration, batch) VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO migrations (id, migration, batch) VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO migrations (id, migration, batch) VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);
create table password_resets
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);