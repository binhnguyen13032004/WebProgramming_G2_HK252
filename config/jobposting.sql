drop schema if exists `jobposting`;
create schema `jobposting`;
use `jobposting`;

CREATE TABLE `job_title` (
    `name` VARCHAR(100) PRIMARY KEY
);

CREATE TABLE `job_category` (
    `name` VARCHAR(100) PRIMARY KEY
);

CREATE TABLE `industry` (
    `name` VARCHAR(100) PRIMARY KEY
);

CREATE TABLE `employment_type` (
    `name` VARCHAR(100) PRIMARY KEY
);

CREATE TABLE `job_level` (
    `name` VARCHAR(10) PRIMARY KEY
);
insert into `job_level`
values ("Junior"), ("Mid"), ("Senior");

CREATE TABLE `salary` (
    `name` int PRIMARY KEY
);

CREATE TABLE `salary_type` (
    `name` VARCHAR(20) PRIMARY KEY
);
insert into `salary_type`
values ("Gross"), ("Net");

CREATE TABLE `skill` (
    `name` VARCHAR(30) PRIMARY KEY
);

CREATE TABLE `min_proficiency` (
    `name` VARCHAR(30) PRIMARY KEY
);

CREATE TABLE `district` (
    `name` VARCHAR(30) PRIMARY KEY
);

CREATE TABLE `country` (
    `name` VARCHAR(30) PRIMARY KEY
);

CREATE TABLE `cityprovince` (
    `name` VARCHAR(30) PRIMARY KEY
);

CREATE TABLE `work_arrangement` (
    `name` VARCHAR(10) PRIMARY KEY
);
insert into `work_arrangement`
values ("Onsite"), ("Remote"), ("Hybrid");

CREATE TABLE `min_degree_level` (
    `name` VARCHAR(30) PRIMARY KEY
);

CREATE TABLE `min_experience_years` (
    `name` VARCHAR(30) PRIMARY KEY
);

create table `user_role` (
	`id` int auto_increment primary key,
    `name` varchar(20) unique not null
    );
insert into `user_role`(`name`)
values ("Admin"), ("Employer"), ("Jobseeker");

create table `user` (
	`id` int auto_increment primary key,
    `email` varchar(50) unique not null,
    `password` varchar(256) not null, -- use bcrypt to generate hash before putting it in the table
    `name` varchar(100) not null,
    `role` int not null,
    foreign key (`role`) references `user_role`(`id`) on delete cascade
);

create table `job_vacancy` (
	`job_id` int auto_increment primary key,
    `job_responsibilities` varchar(1000) not null,
    `required_qualifications` varchar(1000) not null,
    `preferred_skills` varchar(1000) not null,
    `notes` varchar(500) not null,
    `date_created` date not null
);

create table `job_information` (
	`job_id` int primary key,
    `employment_type` varchar(100) not null,
    `job_title` varchar(100) not null,
    `job_category` varchar(100) not null,
    `industry` varchar(100) not null,
    `job_level` varchar(10) not null,
    `opening_count` int not null default 0,
    foreign key (`job_id`) references `job_vacancy`(`job_id`) on delete cascade,
    foreign key (`employment_type`) references `employment_type`(`name`) on update cascade on delete cascade,
    foreign key (`job_title`) references `job_title`(`name`) on update cascade on delete cascade,
    foreign key (`job_category`) references `job_category`(`name`) on update cascade on delete cascade,
    foreign key (`industry`) references `industry`(`name`) on update cascade on delete cascade,
    foreign key (`job_level`) references `job_level`(`name`) on update cascade on delete cascade
);

create table `job_location` (
	`job_id` int primary key,
    `country` varchar(30) not null,
    `district` varchar(30),
    `cityprovince` varchar(30) not null,
    `work_arrangement` varchar(10) not null,
    foreign key (`job_id`) references `job_vacancy`(`job_id`) on delete cascade,
    foreign key (`country`) references `country`(`name`) on update cascade on delete cascade,
    foreign key (`district`) references `district`(`name`) on update cascade on delete cascade,
    foreign key (`cityprovince`) references `cityprovince`(`name`) on update cascade on delete cascade,
    foreign key (`work_arrangement`) references `work_arrangement`(`name`) on update cascade on delete cascade
);

create table `required_skills` (
	`job_id` int not null,
    `skill` varchar(30) not null,
    `min_proficiency` varchar(30) not null,
    primary key (`job_id`, `skill`),
    foreign key (`job_id`) references `job_vacancy`(`job_id`) on delete cascade,
    foreign key (`skill`) references `skill`(`name`) on update cascade on delete cascade,
    foreign key (`min_proficiency`) references `min_proficiency`(`name`) on update cascade on delete cascade
);

create table `salary_benefits` (
	`job_id` int primary key,
    `min` int not null,
    `max` int not null,
    `type` varchar(20) not null,
    `benefits` varchar(1000) not null,
    foreign key (`job_id`) references `job_vacancy`(`job_id`) on delete cascade,
    foreign key (`min`) references `salary`(`name`) on update cascade on delete cascade,
    foreign key (`max`) references `salary`(`name`) on update cascade on delete cascade,
    foreign key (`type`) references `salary_type`(`name`) on update cascade on delete cascade
);

create table `required_education_experience` (
	`job_id` int primary key,
    `min_degree_level` varchar(30) not null,
    `min_experience_years` varchar(30) not null,
    foreign key (`job_id`) references `job_vacancy`(`job_id`) on delete cascade,
    foreign key (`min_degree_level`) references `min_degree_level`(`name`) on update cascade on delete cascade,
    foreign key (`min_experience_years`) references `min_experience_years`(`name`) on update cascade on delete cascade
);

create table `employer_creates_jobpost` (
	`employer_id` int not null,
    `job_id` int not null,
    primary key (`employer_id`, `job_id`),
    foreign key (`employer_id`) references `user`(`id`) on delete cascade, -- Make sure usertype is employer
    foreign key (`job_id`) references `job_vacancy`(`job_id`) on delete cascade
);