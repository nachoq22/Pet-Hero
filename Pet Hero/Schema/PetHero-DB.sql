drop database if exists petHero;
drop table if exists Location;
drop table if exists Keeper;
drop table if exists Owner;
drop table if exists Size;
drop table if exists Dog;
/********************************************************************************************/

create database if not exists petHero;
use petHero;

/********************************************************************************************/
create table if not exists Location(
	idLocation int not null unique auto_increment primary key,
    adress varchar(40),
    neighborhood varchar(20),
    city varchar(20),
    province varchar(30),
    country varchar(20)
);

insert into Location values (0,"Rondeau 616","Piedras del sol","Cordoba","Cordoba","Argentina");
insert into Location values (0,"Av. 3 de Abril 827","Mariano","Corrientes","Corrientes","Argentina");
insert into Location values (0,"Av San Martín 1143","Arbolito","Ciudad de Mendoza","Mendoza","Argentina");
insert into Location values (0,"Rondeau 616","Mitre","San Fernando","Buenos Aires","Argentina");
insert into Location values (0,"San Martín 2365","Termas Saladas","Santa Fe","Santa Fe","Argentina");
insert into Location values (0,"Pedro Morán 4441","Moron","Ciudad Autónoma de Buenos Aires","Buenos Aires","Argentina");
insert into Location values (0,"Cerrito 20","Alba Azul","Rosario","Santa Fe","Argentina");
insert into Location values (0,"12 De Octubre 3179","Puerto Feo","Mar del Plata","Buenos Aires","Argentina");
insert into Location values (0,"Pio Xii 366","El Floral","Santa Rosa","La Pampa","Argentina");
insert into Location values (0,"Pigue 1996","Pompeya","Mar del Plata","Buenos Aires","Argentina");

/********************************************************************************************/
create table if not exists Keeper(
	idKeeper int not null unique auto_increment primary key,
    name varchar(20),
    surname varchar(20),
    sex varchar(1),
    dni varchar(8) unique not null check(dni regexp '[0-9]{8}'),
    idLocation int not null,
    constraint fk_KeeperLocation foreign key (idLocation)
    references Location(idLocation)
);

insert into Keeper values (0,"Santino","Escobedo","M","28418700",1);
insert into Keeper values (0,"Maximiliano","Sanz","M","41844906",2);
insert into Keeper values (0,"Josefina","Herrera","F","67154484",3);
insert into Keeper values (0,"Ashley","Benitez","F","88403165",4);
insert into Keeper values (0,"Alan","Rojas","M","40737343",5);

/********************************************************************************************/
create table if not exists Owner(
	idOwner int not null unique auto_increment primary key,
    name varchar(20),
    surname varchar(20),
    sex varchar(1),
	dni varchar(8) unique not null check(dni regexp '[0-9]{8}'),
    idLocation int not null,
    constraint fk_OwnerLocation foreign key (idLocation)
    references Location(idLocation)
);

insert into Owner values (0,"Valery","Granado","F","71963031",6);
insert into Owner values (0,"Gabriela","Garrido","F","56777159",7);
insert into Owner values (0,"Martín","Gimenez","M","24184906",8);
insert into Owner values (0,"Hugo","Mendez","M","64865433",9);
insert into Owner values (0,"Máximo","Martin","M","12249486",10);

/********************************************************************************************/
create table if not exists Size(
	idSize int not null unique auto_increment primary key,
    name varchar(30)
);

insert into Size values (0,"Little");
insert into Size values (0,"Little-Medium");
insert into Size values (0,"Medium");
insert into Size values (0,"Medium-Big");
insert into Size values (0,"Big");

/********************************************************************************************/
create table if not exists Dog(
	idDog int not null unique auto_increment primary key,
    name varchar(20),
    breed varchar(20),
	vaccinationPlanIMG varchar(60),
    observation varchar(60),
    idSize int not null,
    idOwner int not null,
    constraint fk_DogSize foreign key (idSize)
    references Size(idSize),
    constraint fk_DogOwner foreign key (idOwner)
    references Owner(idOwner)
);

insert into Dog values (0,"Coco","Mestizo","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogCM-131020221731.jpg","Esta re duro",1,1);
insert into Dog values (0,"Thor","Golden","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogTG-131020221732.jpg","Rompe todo",2,2);
insert into Dog values (0,"Faraon","Labrador","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogFL-131020221732.jpg","Come mucho",3,3);
insert into Dog values (0,"Laila","Ovejero","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogLO-131020221733.jpg","No tiene baño propio",4,4);
insert into Dog values (0,"Willow","Chihuahua","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogWC-131020221734.jpg","Se escapa constantemente",5,5);
