drop database if exists Trackr;

create database Trackr;
use Trackr;

create table `user` (
    id int primary key auto_increment,
    fname varchar(20) not null,
    lname varchar(20) not null,
    email varchar(50) not null,
    `password` varchar(32) not null
);
    
create table to_do_folder (
    id int primary key auto_increment,
    user_id int not null,
    `name` varchar(20) not null,

    foreign key (user_id) references `user` (id) on delete cascade
);

create table contact (
    id int primary key auto_increment,
    user_id int not null,
    fname varchar(20) not null,
    lname varchar(20) not null,
    icon varchar(50),
    street varchar(50),
    zip_code int,
    city varchar(20),
    country varchar(20),
    email varchar(50),
    telephone_no int not null,
    
    foreign key (user_id) references `user` (id) on delete cascade
    );

create table task (
    id int primary key auto_increment,
    folder_id int not null,
    `name` varchar(20) not null,
    `description` varchar(200),
    `date` date not null,
    `time` time,
    important boolean,
    done boolean default 0,

    foreign key (folder_id) references to_do_folder (id) on delete cascade
);

create table challenge (
    id int primary key auto_increment,
    folder_id int not null,
    `name` varchar(20) not null,
    `description` varchar(200),

    foreign key (folder_id) references to_do_folder (id) on delete cascade
);

create table daily_challenge(
    id int primary key auto_increment,
    challenge_id int not null,
    `date` date not null,
    done boolean default false,

    foreign key (challenge_id) references challenge (id) on delete cascade
);

create table contact_task (
    task_id int not null,
    contact_id int not null,
    
    foreign key (task_id) references task (id) on delete cascade,
    foreign key (contact_id) references contact (id) on delete cascade
);

create table mood (
    id int primary key auto_increment,
    user_id int not null,
    mood enum('Happy','Tired','Angry','Sad','Calm') not null,
    `description` varchar(200),
    `date` date,
    
	foreign key (user_id) references `user` (id) on delete cascade
);

create table financial (
    id int primary key auto_increment,
    user_id int not null,
    total int not null,
    total_expenses int not null,
    total_income int not null,
    `month` int not null,
    `year` int not null,
    
    foreign key (user_id) references `user` (id) on delete cascade
);

create table `transaction` (
    id int primary key auto_increment,
    financial_id int not null,
    `name` varchar(20) not null,
    `type` enum('income', 'expenses') not null,
    quantity int not null,
    `date` date not null,
    
    foreign key (financial_id) references financial (id) on delete cascade
);

create table scheduler (
    id int primary key auto_increment,
    user_id int not null,
    `day` enum('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') not null,
    `name` varchar(20) not null,
    initial_time time,
    end_time time,
    
    foreign key (user_id) references `user` (id) on delete cascade
);

create table `schedule` (
    id int primary key auto_increment,
    scheduler_id int not null,
    `name` varchar(20) not null,
    `time` time,
    
    foreign key (scheduler_id) references scheduler (id) on delete cascade
);

create table schedule_task (
    id int primary key auto_increment,
    schedule_id int not null,
    `date` date,
    done boolean,
    
    foreign key (schedule_id) references `schedule` (id) on delete cascade
);
    