use Trackr;

insert into `user` (fname, lname, email, `password`) values ("Sophia", "Mendoza", "sophiamendz04@gmail.com", "3cc31cd246149aec68079241e71e98f6");
insert into `user` (fname, lname, email, `password`) values ("Longjie", "Chao", "ljchao3473@gmail.com", "3cc31cd246149aec68079241e71e98f6");

insert into to_do_folder (user_id, `name`) values (1, "Work");
insert into to_do_folder (user_id, `name`) values (1, "House");
insert into to_do_folder (user_id, `name`) values (1, "Grocery");
insert into to_do_folder (user_id, `name`) values (2, "Work");
insert into to_do_folder (user_id, `name`) values (2, "School");

insert into contact (user_id, fname, lname, icon, street, zip_code, city, country, email, telephone_no) values (1, "Longjie", "Chao", "icon", "Street no. 9", 08191, "Rubi", "Spain", "ljchao3473@gmail.com", 123456789);
insert into contact (user_id, fname, lname, icon, street, zip_code, city, country, email, telephone_no) values (2, "Sophia", "Mendoza", "icon", "Street no. 9", 08191, "Rubi", "Spain", "sophiamendz04@gmail.com", 123456789);

insert into task (folder_id, `name`, `date`, `time`, important) values (1, "Homework", current_date(), current_time(), true);
insert into task (folder_id, `name`, `date`, `time`, `type`, important) values (5, "Work job", current_date(), current_time(), true);
insert into challenge (folder_id, `name`, description) values (5, "Study", "");
insert into challenge (folder_id, `name`, `date`, description) values (1, "Project", "");

insert into contact_task (task_id, contact_id) values (1, 1);
insert into contact_task (task_id, contact_id) values (1, 2);


insert into mood (user_id, mood, `date`) values (1, "Calm", current_date());
insert into mood (user_id, mood, description, `date`) values (2, "Tired", "","2021-05-21");
insert into mood (user_id, mood, description, `date`) values (2, "Happy", "finish the project","2021-06-03");
insert into mood (user_id, mood, description, `date`) values (2, "Tired", "Woke up too early, today im tired","2021-06-04");
insert into mood (user_id, mood, description, `date`) values (2, "Sad", "Feeling down because I didnt do anything, again","2021-06-05");
insert into mood (user_id, mood, description, `date`) values (2, "Exited", "We almost finished the project!!!","2021-06-06");
insert into mood (user_id, mood, description, `date`) values (2, "Happy", "The project is done, im just happy",current_date());


-- insert into financial (user_id, total, total_expenses, total_income, `month`, `year`) values (1, 100, 50, 150, 5, 2021);
-- insert into financial (user_id, total, total_expenses, total_income, `month`, `year`) values (1, 100, 50, 150, 6, 2021);
insert into financial (user_id, total, total_expenses, total_income, `month`, `year`) values (2, 40, 130, 170, 5, 2021);
insert into financial (user_id, total, total_expenses, total_income, `month`, `year`) values (2, 40, 130, 170, 6, 2021);

insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (1, "mcdonald's", 20, "expenses", "2021-04-21");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (1, "present", 30, "income", "2021-04-23");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (1, "bills", 150, "expenses", "2021-04-05");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (1, "work", 100, "income", "2021-04-15");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (1, "water", 50, "expenses", "2021-04-23");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (2, "mcdonald's", 20, "expenses", "2021-05-21");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (2, "present", 30, "income", "2021-05-23");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (2, "bills", 100, "expenses", "2021-05-05");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (2, "work", 100, "income", "2021-05-15");
insert into `transaction` (financial_id, `name`, quantity, `type`, `date`) values (2, "water", 50, "expenses", "2021-05-23");

insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Monday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Tuesday", "Work", "8:00", "21:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Wednesday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Thursday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Friday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Saturday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (1, "Sunday", "Work", "8:00", "17:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (1, "Meeting", "9:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (2, "Presentation", "12:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (3, "Tasks", "15:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (4, "Meeting", "9:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (5, "Presentation", "12:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (6, "Tasks", "15:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (7, "Meeting", "9:00");

insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Monday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Tuesday", "Work", "8:00", "21:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Wednesday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Thursday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Friday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Saturday", "Work", "8:00", "17:00");
insert into scheduler (user_id, `day`, `name`, initial_time, end_time) values (2, "Sunday", "Work", "8:00", "17:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (8, "Meeting", "9:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (9, "Presentation", "12:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (10, "Tasks", "15:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (11, "Meeting", "9:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (12, "Presentation", "12:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (13, "Tasks", "15:00");
insert into `schedule` (scheduler_id, `name`, `time`) values (14, "Meeting", "9:00");
