﻿drop table if exists User;
drop table if exists Ticket;
drop table if exists Hashtag;
drop table if exists TicketHashtag;
drop table if exists Department;
drop table if exists Change;
drop table if exists Message;
drop table if exists FAQ;

CREATE TABLE User(
   name varchar(60) not null,
   username varchar(20) primary key,
   email varchar(60) not null,
   password varchar(40) not null,
   type varchar(5) not null, /*user, agent, admin*/
   department varchar(20),
   ticket_count integer default 0,
   closed_tickets integer default 0);

CREATE TABLE Ticket(
   id integer primary key autoincrement,
   title varchar(60) not null,
   client varchar(20) not null,
   agent varchar(20),
   status varchar(10) not null,
   department varchar(20),
   foreign key (client) references User(username),
   foreign key (agent) references User(username),
   foreign key (department) references Department(name)
);

CREATE TABLE sqlite_sequence(name,seq);

CREATE TABLE Hashtag(
   tag varchar(20) primary key
);

CREATE TABLE TicketHashtag(
   ticketId integer not null,
   tag varchar(20) not null,
   primary key(ticketId, tag),
   foreign key (ticketId) references Ticket(id),
   foreign key (tag) references Hashtag(tag)
);

CREATE TABLE Department(
   name varchar(20) primary key
);

CREATE TABLE FAQ(
   id integer primary key autoincrement,
   question text not null,
   answer text not null
);

CREATE TABLE Message(
   id integer primary key autoincrement,
   ticketId integer not null,
   isFromClient boolean not null,
   message text not null,
   author varchar(20) not null,
   datetime datetime not null,
   foreign key (ticketId) references Ticket(id)
);

CREATE TABLE Change(
   id integer primary key autoincrement,
   ticketId integer not null,
   agent varchar(20),
   action text,
   datetime datetime not null,
   foreign key (ticketId) references Ticket(id),
   foreign key (agent) references User(id)
);
