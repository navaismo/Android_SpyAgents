BEGIN TRANSACTION;
CREATE TABLE Spy_ID
(
       id          varchar(80)     not null default '',
       name        varchar(255)    not null default ''
);
CREATE TABLE Spy_ID_CDR
(
       id          varchar(80)     not null default '',
       name        varchar(255)    not null default '',
       spiedchan   varchar(255)    not null default '',
       fromext     varchar(255)    not null default '',
       date        datetime        not null default '0000-00-00 00:00:00'
);

COMMIT;
