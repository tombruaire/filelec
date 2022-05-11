Drop database if exists filelec;
Create database filelec;
Use filelec;

Create table client (
    idclient int(11) not null auto_increment,
    nom varchar(30),
    tel varchar(10) UNIQUE,
    email varchar(50) UNIQUE,
    mdp varchar(255),
    adresse varchar(100),
    cp varchar(5),
    ville varchar(50),
    pays varchar(50),
    etat enum("Prospect", "Client actif", "Client très actif"),
    role enum("client", "admin"),
    nbTentatives int not null default 0,
    bloque int not null default 0,
    nbConnexion int not null default 0,
    type enum("Particulier", "Professionnel"),
    date_creation_mdp datetime,
    date_dernier_changement_mdp datetime,
    date_creation_compte datetime,
    primary key (idclient)
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vclient (idclient, nom, tel, email, mdp, adresse, cp, ville, pays, etat, role, nbTentatives, bloque, nbConnexion, type, date_creation_mdp, date_dernier_changement_mdp, date_creation_compte)
as select idclient, nom, tel, email, mdp, adresse, cp, ville, pays, etat, role, nbTentatives, bloque, nbConnexion, type, date_format(date_creation_mdp, '%d/%m/%Y %H:%i'), date_format(date_dernier_changement_mdp, '%d/%m/%Y %H:%i'), date_format(date_creation_compte, '%d/%m/%Y %H:%i')
from client;

Create table histoClient as select *, sysdate() dateHeureAction, user() user, '__________' action
From client
Where 2=0;

Drop trigger if exists insertClient;
Delimiter //
Create trigger insertClient
After insert on client
For each row
Begin
    insert into histoClient select *, sysdate(), user(), 'INSERT'
    from client
    where idclient = new.idclient;
End //
Delimiter ;

Drop trigger if exists updateClient;
Delimiter //
Create trigger updateClient
Before update on client
For each row
Begin
    insert into histoClient select *, sysdate(), user(), 'UPDATE'
    from client
    where idclient = old.idclient;
End //
Delimiter ;

Drop trigger if exists deleteClient;
Delimiter //
Create trigger deleteClient
Before delete on client
For each row
Begin
    insert into histoClient select *, sysdate(), user(), 'DELETE'
    from client
    where idclient = old.idclient;
End //
Delimiter ;

Create table particulier (
    idclient int(11) not null,
    nom varchar(30),
    prenom varchar(30),
    tel varchar(10) UNIQUE,
    email varchar(50) UNIQUE,
    mdp varchar(255),
    adresse varchar(100),
    cp varchar(5),
    ville varchar(50),
    pays varchar(50),
    etat enum("Prospect", "Client actif", "Client très actif"),
    role enum("client", "admin"),
    nbTentatives int not null default 0,
    bloque int not null default 0,
    nbConnexion int not null default 0,
    type enum("Particulier", "Professionnel"),
    date_creation_mdp datetime,
    date_dernier_changement_mdp datetime,
    date_creation_compte datetime,
    primary key (idclient),
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Drop function if exists countTelParticulier;
Delimiter //
Create function countTelParticulier(newtel varchar(10))
returns int
Begin
    select count(*) from particulier where tel = newtel into @result;
    return @result;
End //
Delimiter ;

Drop trigger if exists checkTelParticulier;
Delimiter //
Create trigger checkTelParticulier
Before insert on particulier
For each row
Begin
    if countTelParticulier(new.tel)
        then signal sqlstate '45000'
        set message_text = 'Telephone deja utilisee !';
    end if ;
End //
Delimiter ;

Drop function if exists countEmailParticulier;
Delimiter //
Create function countEmailParticulier(newemail varchar(50))
returns int
Begin
    select count(*) from particulier where email = newemail into @result;
    return @result;
End //
Delimiter ;

Drop trigger if exists checkEmailParticulier;
Delimiter //
Create trigger checkEmailParticulier
Before insert on particulier
For each row
Begin
    if countEmailParticulier(new.email)
        then signal sqlstate '45000'
        set message_text = 'Email deja utilisee !';
    end if ;
End //
Delimiter ;

Drop procedure if exists insertParticulier;
Delimiter //
Create procedure insertParticulier(in p_nom varchar(30), in p_prenom varchar(30), in p_tel varchar(10), in p_email varchar(50), in p_mdp varchar(255), in p_adresse varchar(100), in p_cp varchar(5), in p_ville varchar(50), in p_pays varchar(50), in p_etat enum("Prospect", "Client actif", "Client très actif"), in p_role enum("client", "admin"))
Begin
    declare p_idclient int(11);
    insert into client values (null, p_nom, p_tel, p_email, sha1(p_mdp), p_adresse, p_cp, p_ville, p_pays, p_etat, p_role, 0, 0, 0, 'Particulier', sysdate(), sysdate(), sysdate());
    select idclient into p_idclient
    from client
    where tel = p_tel and email = p_email;
    insert into particulier values (p_idclient, p_nom, p_prenom, p_tel, p_email, sha1(p_mdp), p_adresse, p_cp, p_ville, p_pays, p_etat, p_role, 0, 0, 0, 'Particulier', sysdate(), sysdate(), sysdate());
End //
Delimiter ;

call insertParticulier('FOUQUET', 'Valiant', '0353952424', 'valiant.fouquet@gmail.com', 'ZuGh5iW2of1', '3, rue des lieutemants Thomazo', '59500', 'DOUAI', 'France', 'Prospect', 'client');
call insertParticulier('GOULET', 'Issac', '0214316122', 'issac.goulet@gmail.com', 'eesh4Yush', '15, rue Michel Ange', '76600', 'LE HAVRE', 'France', 'Prospect', 'client');
call insertParticulier('LOISELLE', 'Julie', '0451596927', 'julie.loiselle@gmail.com', 'ooh3aiXie', '15, rue des Soeurs', '06160', 'JUAN-LES-PINS', 'France', 'Prospect', 'client');

# COMPTE(S) TEST
-- Compte particulier (admin)
call insertParticulier('BRUAIRE', 'Tom', '0101010101', 'tom.bruaire@gmail.com', 'Azerty123', '5, rue de Levallois', '92300', 'LEVALLOIS-PERRET', 'France', 'Prospect', 'admin');

Drop procedure if exists updateParticulier;
Delimiter //
Create procedure updateParticulier(in p_nom varchar(30), in p_prenom varchar(30), in p_tel varchar(10), in p_email varchar(50), in p_mdp varchar(255), in p_adresse varchar(100), in p_cp varchar(5), in p_ville varchar(50), in p_pays varchar(50), in p_etat enum("Prospect", "Client actif", "Client très actif"), in p_role enum("client", "admin"), in p_bloque int, in p_nbConnexion int, in p_date_changement_mdp datetime)
Begin
    update client set nom = p_nom, tel = p_tel, email = p_email, mdp = sha1(p_mdp), adresse = p_adresse, cp = p_cp, ville = p_ville, pays = p_pays, etat = p_etat, role = p_role, bloque = p_bloque, nbConnexion = p_nbConnexion, date_dernier_changement_mdp = p_date_changement_mdp
    where tel = p_tel and email = p_email;
    update particulier set nom = p_nom, prenom = p_prenom, tel = p_tel, email = p_email, mdp = sha1(p_mdp), adresse = p_adresse, cp = p_cp, ville = p_ville, pays = p_pays, etat = p_etat, role = p_role, bloque = p_bloque, nbConnexion = p_nbConnexion, date_dernier_changement_mdp = p_date_changement_mdp
    where tel = p_tel and email = p_email;
End //
Delimiter ;

Drop procedure if exists deleteParticulier;
Delimiter //
Create procedure deleteParticulier(in p_tel varchar(10), in p_email varchar(50))
Begin
    delete from particulier where tel = p_tel and email = p_email;
    delete from client where tel = p_tel and email = p_email;
End //
Delimiter ;

Create table professionnel (
    idclient int(11) not null,
    nom varchar(30),
    tel varchar(10) UNIQUE,
    email varchar(50) UNIQUE,
    mdp varchar(255),
    adresse varchar(100),
    cp varchar(5),
    ville varchar(50),
    pays varchar(50),
    numSIRET varchar(50),
    statut varchar(30),
    etat enum("Prospect", "Client actif", "Client très actif"),
    role enum("client", "admin"),
    nbTentatives int not null default 0,
    bloque int not null default 0,
    nbConnexion int not null default 0,
    type enum("Particulier", "Professionnel"),
    date_creation_mdp datetime,
    date_dernier_changement_mdp datetime,
    date_creation_compte datetime,
    primary key (idclient)
) ENGINE=InnoDB, CHARSET=utf8;

Drop function if exists countTelProfessionnel;
Delimiter //
Create function countTelProfessionnel(newtel varchar(10))
returns int
Begin
    select count(*) from professionnel where tel = newtel into @result;
    return @result;
End //
Delimiter ;

Drop trigger if exists checkTelProfessionnel;
Delimiter //
Create trigger checkTelProfessionnel
Before insert on particulier
For each row
Begin
    if countTelProfessionnel(new.tel)
        then signal sqlstate '45000'
        set message_text = 'Telephone deja utilisee !';
    end if ;
End //
Delimiter ;

Drop function if exists countEmailProfessionnel;
Delimiter //
Create function countEmailProfessionnel(newemail varchar(50))
returns int
Begin
    select count(*) from professionnel where email = newemail into @result;
    return @result;
End //
Delimiter ;

Drop trigger if exists checkEmailProfessionnel;
Delimiter //
Create trigger checkEmailProfessionnel
Before insert on professionnel
For each row
Begin
    if countEmailProfessionnel(new.email)
        then signal sqlstate '45000'
        set message_text = 'Email deja utilisee !';
    end if ;
End //
Delimiter ;

Drop procedure if exists insertProfessionnel;
Delimiter //
Create procedure insertProfessionnel(in p_nom varchar(30), in p_tel varchar(10), in p_email varchar(50), in p_mdp varchar(255), in p_adresse varchar(100), in p_cp varchar(5), in p_ville varchar(50), in p_pays varchar(50), in p_numSIRET varchar(50), in p_statut varchar(30), in p_etat enum("Prospect", "Client actif", "Client très actif"), in p_role enum("client", "admin"))
Begin
    declare p_idclient int(11);
    insert into client values (null, p_nom, p_tel, p_email, sha1(p_mdp), p_adresse, p_cp, p_ville, p_pays, p_etat, p_role, 0, 0, 0, 'Professionnel', sysdate(), sysdate(), sysdate());
    select idclient into p_idclient
    from client
    where tel = p_tel and email = p_email;
    insert into professionnel values (p_idclient, p_nom, p_tel, p_email, sha1(p_mdp), p_adresse, p_cp, p_ville, p_pays, p_numSIRET, p_statut, p_etat, p_role, 0, 0, 0, 'Professionnel', sysdate(), sysdate(), sysdate());
End //
Delimiter ;

call insertProfessionnel('FONGEMIE', '0262560147', 'nicole.fongemie@gmail.com', 'Haqu1oeJat2', '95, place Stanislas', '44000', 'NANTES', 'France', '521 868 267 00014', 'SARL', 'Prospect', 'client');
call insertProfessionnel('FONTAINE', '0173212847', 'vincent.fontaine@gmail.com', 'Io0ko0ohThi', '88, rue de Raymond Poincare', '92200', 'NEUILLY-SUR-SEINE', 'France', '521 868 267 00014', 'SARL', 'Prospect', 'client');
call insertProfessionnel('RUEL', '0261022699', 'gauthier.ruel@gmail.com', 'Oosaiw9keeBee', '91, rue Lenotre', '35000', 'RENNES', 'France', '521 868 267 00014', 'SARL', 'Prospect', 'client');

# COMPTE(S) TEST
-- Compte professionnel (admin)
call insertProfessionnel('PLOUFFE', '0202020202', 'raoul.plouffe@gmail.com', 'Azerty123', '61, rue Franklin Roosevelt', '13009', 'MARSEILLE', 'France', '521 868 267 00014', 'SARL', 'Prospect', 'admin');

Drop procedure if exists updateProfessionnel;
Delimiter //
Create procedure updateProfessionnel(in p_nom varchar(30), in p_tel varchar(10), in p_email varchar(50), in p_mdp varchar(255), in p_adresse varchar(100), in p_cp varchar(5), in p_ville varchar(50), in p_pays varchar(50), in p_statut varchar(30), in p_etat enum("Prospect", "Client actif", "Client très actif"), in p_role enum("client", "admin"), in p_bloque int, in p_nbConnexion int, in p_date_changement_mdp datetime)
Begin
    update client set nom = p_nom, tel = p_tel, email = p_email, mdp = sha1(p_mdp), adresse = p_adresse, cp = p_cp, ville = p_ville, pays = p_pays, etat = p_etat, role = p_role, bloque = p_bloque, nbConnexion = p_nbConnexion, date_dernier_changement_mdp = p_date_changement_mdp
    where tel = p_tel and email = p_email;
    update professionnel set nom = p_nom, tel = p_tel, email = p_email, mdp = sha1(p_mdp), adresse = p_adresse, cp = p_cp, ville = p_ville, pays = p_pays, statut = p_statut, etat = p_etat, role = p_role, bloque = p_bloque, nbConnexion = p_nbConnexion, date_dernier_changement_mdp = p_date_changement_mdp
    where tel = p_tel and email = p_email;
End //
Delimiter ;

Drop procedure if exists deleteProfessionnel;
Delimiter //
Create procedure deleteProfessionnel(in p_tel varchar(10), in p_email varchar(50))
Begin
    delete from professionnel where tel = p_tel and email = p_email;
    delete from client where tel = p_tel and email = p_email;
End //
Delimiter ;

Create table type (
    idtype int(11) not null auto_increment,
    libelle varchar(50) not null UNIQUE,
    primary key (idtype)
) ENGINE=InnoDB, CHARSET=utf8;

Insert into type values
(null, 'Autoradio'),
(null, 'GPS'),
(null, 'Aide a la conduite'),
(null, 'Haut-parleurs'),
(null, 'Kit mains-libre'),
(null, 'Amplificateur');

Create table histoType as select *, sysdate() dateHeureAction, user() user, '__________' action
From type
Where 2=0;

Alter table histoType
add primary key (idtype, dateHeureAction);

Drop trigger if exists insertType;
Delimiter //
Create trigger insertType
After insert on type
For each row
Begin
    Insert into histoType select *, sysdate(), user(), 'INSERT'
    From type
    Where idtype = new.idtype;
End //
Delimiter ;

Drop trigger if exists updateType;
Delimiter //
Create trigger updateType
Before update on type
For each row
Begin
    Insert into histoType select *, sysdate(), user(), 'UPDATE'
    From type
    Where idtype = old.idtype;
End //
Delimiter ;

Drop trigger if exists deleteType;
Delimiter //
Create trigger deleteType
Before delete on type
For each row
Begin
    Insert into histoType select *, sysdate(), user(), 'DELETE'
    From type
    Where idtype = old.idtype;
End //
Delimiter ;

Drop trigger if exists checkTypeInsert;
Delimiter //
Create trigger checkTypeInsert
Before insert on type
For each row
Begin
    if new.libelle = (select libelle from type where libelle = new.libelle)
        then signal sqlstate '45000'
        set message_text = 'Ce type est déjà enregistré !';
    end if ;
End //
Delimiter ;

Create table produit (
    idproduit int(11) not null auto_increment,
    nomproduit varchar(100) not null UNIQUE,
    imageproduit varchar(255),
    descriptionproduit longtext,
    qteproduit int(3) not null,
    prixproduit decimal(6,2) not null,
    idtype int(11) not null,
    date_ajout datetime,
    primary key (idproduit),
    foreign key (idtype) references type (idtype)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Insert into produit values

-- Autoradio
(null, 'TOKAI LAR-15B', 'TOKAI_LAR-15B.png', 'Telephonie mains-libre via Bluetooth.', 22, 19.99, 1, sysdate()),
(null, 'PIONEER MVH-S110UB', 'PIONEER_MVH-S110UB.png', 'Controle de l autoradio a partir d un smartphone.', 25, 39.99, 1, sysdate()),
(null, 'SONY WX-920BT', 'SONY_WX-920BT.png', 'Telephonie mains-libre via Bluetooth et commande vocale SIRI.', 30, 199.99, 1, sysdate()),
(null, 'JVC KW-V420BT', 'JVC_KW-V420BT.png', 'Telephonie mains-libre via Bluetooth et commande vocale SIRI.', 5, 399.99, 1, sysdate()),

-- GPS
(null, 'MAPPY ULTI E538', 'MAPPY_ULTI_E538.png', 'Limitation de vitesse et mode de visualisation RealView.', 3, 79.99, 2, sysdate()),
(null, 'GARMIN DRIVE 51 LMT-S SE', 'GARMIN_DRIVE_51_LMT-S_SE.png', 'Alerte les zones de danger et carte de l Europe (15 pays) gratuits a vie', 5, 129.99, 2, sysdate()),
(null, 'POIDS LOURD SNOOPER PL6600', 'POIDS_LOURD_SNOOPER_PL6600.png', 'Guidage pernant en compte le gabarit.', 7, 599.0, 2, sysdate()),
(null, 'PIONEER AVIC-F88DAB', 'PIONEER_AVIC-F88DAB.png', 'Carte de l Europe (45 pays) et info trafic, compatible avec Apple Card Pay et Android Auto.', 8, 1299, 2, sysdate()),

-- Aide à la conduite
(null, 'CAMERA DE RECUL BEEPER RWEC100X-RF', 'CAMERA_DE_RECUL_BEEPER_RWEC100X-RF.png', 'Angle de vue de 140° horizontale.', 9, 199.99, 3, sysdate()),
(null, 'CAMERA DE RECUL BEEPER RWE200X-BL', 'CAMERA_DE_RECUL_BEEPER_RWEC200X-BL.png', 'Angle de vue 140° horizontale.', 10, 359.99, 3, sysdate()),
(null, 'CAMERA EMBARQUEE NEXTBASE NBDVR-101 HD', 'CAMERA_EMBARQUEE_NEXTBASE_NBDVR-101_HD.png', 'Angle de vue 120°, sortie audio AV et microphone integre.', 11, 89.99, 3, sysdate()),
(null, 'CAMERA DE RECUL + ECRAN BEEPER RW037-P', 'CAMERA_DE_RECUL_+_ECRAN_BEEPER_RW037-P.png', 'Angle de vue 150° horizontale.', 12, 89.99, 3, sysdate()),

-- Haut-parleurs
(null, 'PIONEER Ts-13020 I', 'PIONEER_Ts-13020_I.png', 'Diametre de 13 cm et puissance de 130 Watts.', 13, 22.99, 4, sysdate()),
(null, 'FOCAL 130 AC', 'FOCAL_130_AC.png', 'Diametre de 13 cm et puissance de 100 Watts.', 14, 89.99, 4, sysdate()),
(null, 'MTX T6S652', 'MTX_T6S652.png', 'Diametre de 16.5 cmd et puissance de 400 Watts.', 15, 129.99, 4, sysdate()),
(null, 'FOCAL PS 165 F3', 'FOCAL_PS_165_F3.png', 'Diametre de 16.5cm et puissance de 160 Watts.', 16, 399, 4, sysdate()),

-- Kit mains-libre
(null, 'SUPERTOOTH BUDDY NOIR', 'SUPERTOOTH_BUDDY_NOIR.png', 'Connexion simultanee de 2 telephones, reconnexion automatique au telephone.', 17, 35.99, 5, sysdate()),
(null, 'PARROT NEO 2 HD', 'PARROT_NEO_2_HD.png', 'Connexion simultanee de 2 telephones, applications smartphones dediee avec fonction exclusives', 18, 79.99, 5, sysdate()),
(null, 'PARROT MKI9200', 'PARROT_MKI9200.png', 'Diffusion vocale et musicale sur les hauts-parleurs, telecommande sans fil positionnable au volant, connexion simultanee de 2 telephones.', 19, 249, 5, sysdate()),
(null, 'PARROT MKI9000', 'PARROT_MKI9000.png', 'Diffusion vocale et musicale sur les hauts-parleurs, connexion simultanee de 2 telephones, conversation de qualite grace aux douvles microphones.', 20, 169.99, 5, sysdate()),

-- Amplificateur
(null, 'MTX RFL4001D', 'MTX_RFL4001D.png', 'Puissance maximale de 12 000 Watts, dimensions en cm : 20.4 x 62.6 x 5.9', 21, 999, 6, sysdate()),
(null, 'JBL GX-A3001', 'JBL_GX-A3001.png', 'Puissance maximale de 415 Watts, dimensions en cm : 10.8 x 33.6 x 25', 22, 149.99, 6, sysdate()),
(null, 'MTX TR275', 'MTX_TR275.png', 'Puissance de 660 Watts, dimensions en cm : 14.2 x 13.4 x 5.1', 23, 275, 6, sysdate()),
(null, 'CALIBEER CA75.2', 'CALIBEER_CA75.2.png', 'Puissance maximale de 150 Watts, dimensions en cm : 3.8 x 7.8 x 10', 24, 42.99, 6, sysdate());

Create or replace view vproduit (idproduit, nomproduit, imageproduit, descriptionproduit, qteproduit, prixproduit, libelle, date_ajout) as
select p.idproduit, p.nomproduit, p.imageproduit, p.descriptionproduit, p.qteproduit, p.prixproduit, t.libelle, date_format(date_ajout, '%d/%m/%Y %H:%i')
from produit p, type t
where p.idtype = t.idtype
group by idproduit;

Create table histoProduit as select *, sysdate() dateHeureAction, user() user, '__________' action
from produit
where 2=0;

Drop trigger if exists insertProduit;
Delimiter //
Create trigger insertProduit
After insert on produit
For each row
Begin
    insert into histoProduit select *, sysdate(), user(), 'INSERT'
    from produit
    where idproduit = new.idproduit;
End //
Delimiter ;

Drop trigger if exists updateProduit;
Delimiter //
Create trigger updateProduit
Before update on produit
For each row
Begin
    insert into histoProduit select *, sysdate(), user(), 'UPDATE'
    from produit
    where idproduit = old.idproduit;
End //
Delimiter ;

Drop trigger if exists deleteProduit;
Delimiter //
Create trigger deleteProduit
Before delete on produit
For each row
Begin
    insert into histoProduit select *, sysdate(), user(), 'DELETE'
    from produit
    where idproduit = old.idproduit;
End //
Delimiter ;

/* Triggers qui vérifient que le prix du produit ne soit pas en-dessous de 0 (prix<0) */
Drop trigger if exists verifPrixInsert;
Delimiter //
Create trigger verifPrixInsert
Before insert on produit
For each row
Begin
    if new.prixProduit <= 0
        then signal sqlstate '45000'
        set message_text = 'Le prix ne doit pas être inferieur a 0';
    end if ;
End //
Delimiter ;

Drop trigger if exists verifPrixUpdate;
Delimiter //
Create trigger verifPrixUpdate
Before update on produit
For each row
Begin
    if new.prixProduit <= 0
        then signal sqlstate '45000'
        set message_text = 'Le prix ne doit pas être inferieur a 0';
    end if ;
End //
Delimiter ;

Create table commande (
    numcommande int(8) not null auto_increment,
    idclient int(11) not null,
    mode_payement varchar(50) default null,
    etat varchar(100) default null,
    montantTotalHT decimal(12,2),
    montantTotalTTC decimal(12,2),
    TVA decimal(12,2),
    datecommande datetime,
    datelivraision datetime,
    idproduit int(11) not null,
    primary key (numcommande),
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade,
    foreign key (idproduit) references produit (idproduit)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vcommande(numcommande, nom, adresse, cp, ville, pays, mode_payement, etat, montantTotalHT, montantTotalTTC, TVA, datecommande, datelivraison, produit)
as select co.numcommande, cl.nom, cl.adresse, cl.cp, cl.ville, cl.pays, co.mode_payement, co.etat, co.montantTotalHT, co.montantTotalTTC, co.TVA, date_format(co.datecommande, '%d/%m/%Y %H:%i'), date_format(co.datelivraision, '%d/%m/%Y %H:%i'), p.nomproduit
from commande co, client cl, produit p
where co.idclient = cl.idclient
and co.idproduit = p.idproduit
group by cl.nom;

Create table histoCommande as select *, sysdate() dateHeureAction, user() user, '__________' action
From commande
Where 2=0;

Alter table histoCommande
add primary key (numcommande, dateHeureAction);

Drop trigger if exists insertCommande;
Delimiter //
Create trigger insertCommande
After insert on commande
For each row
Begin
    insert into histoCommande select *, sysdate(), user(), 'INSERT'
    from commande
    where numcommande = new.numcommande;
End //
Delimiter ;

Drop trigger if exists deleteCommande;
Delimiter //
Create trigger deleteCommande
Before delete on commande
For each row
Begin
    insert into histoCommande select *, sysdate(), user(), 'DELETE'
    from commande
    where numcommande = old.numcommande;
End //
Delimiter ;

Create table panier (
    numcommande int(8) not null,
    idproduit int(11) not null,
    quantite int(3) not null,
    idclient int(11) not null,
    primary key (idproduit),
    foreign key (numcommande) references commande (numcommande)
    on update cascade
    on delete cascade,
    foreign key (idproduit) references produit (idproduit)
    on update cascade
    on delete cascade,
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vpanier(numcommande, idproduit, nomproduit, prixproduit, quantite, montantTotalHT, montantTotalTTC, nomclient, idclient)
as select pa.numcommande, pro.idproduit, pro.nomproduit, pro.prixproduit, pa.quantite, c.montantTotalHT, c.montantTotalTTC, cl.nom, cl.idclient
from panier pa, produit pro, client cl, commande c
where pa.numcommande = c.numcommande
and pa.idproduit = pro.idproduit
and pa.idclient = cl.idclient
group by pa.numcommande;

Create table savecommande (
    numcommande int(8) not null auto_increment,
    idclient int(11) not null,
    mode_payement varchar(50) default null,
    etat varchar(100) default null,
    montantTotalHT decimal(12,2),
    montantTotalTTC decimal(12,2),
    TVA decimal(12,2),
    datecommande datetime,
    datelivraision datetime,
    idproduit int(11) not null,
    primary key (numcommande),
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade,
    foreign key (idproduit) references produit (idproduit)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vsavecommande(numcommande, nom, adresse, cp, ville, pays, mode_payement, etat, montantTotalHT, montantTotalTTC, TVA, datecommande, datelivraison, produit)
as select co.numcommande, cl.nom, cl.adresse, cl.cp, cl.ville, cl.pays, co.mode_payement, co.etat, co.montantTotalHT, co.montantTotalTTC, co.TVA, date_format(co.datecommande, '%d/%m/%Y %H:%i'), date_format(co.datelivraision, '%d/%m/%Y %H:%i'), p.nomproduit
from savecommande co, client cl, produit p
where co.idclient = cl.idclient
and co.idproduit = p.idproduit
group by cl.nom;

Create table savepanier (
    numcommande int(8) not null,
    idproduit int(11) not null,
    quantite int(3) not null,
    idclient int(11) not null,
    primary key (idproduit),
    foreign key (numcommande) references savecommande (numcommande)
    on update cascade
    on delete cascade,
    foreign key (idproduit) references produit (idproduit)
    on update cascade
    on delete cascade,
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vsavepanier(numcommande, idproduit, nomproduit, prixproduit, quantite, montantTotalHT, montantTotalTTC, nomclient, idclient)
as select pa.numcommande, pro.idproduit, pro.nomproduit, pro.prixproduit, pa.quantite, c.montantTotalHT, c.montantTotalTTC, cl.nom, cl.idclient
from savepanier pa, produit pro, client cl, savecommande c
where pa.numcommande = c.numcommande
and pa.idproduit = pro.idproduit
and pa.idclient = cl.idclient
group by pa.numcommande;

Drop trigger if exists transactionInsert;
Delimiter //
Create trigger transactionInsert
After insert on panier
For each row
Begin
    update produit
    set qteproduit = qteproduit - new.quantite
    where idproduit = new.idproduit;
End //
Delimiter ;

/*
Drop trigger if exists transactionInsert2;
Delimiter //
Create trigger transactionInsert2
After insert on savepanier
For each row
Begin
    update produit
    set qteproduit = qteproduit - new.quantite
    where idproduit = new.idproduit;
End //
Delimiter ;
*/

Drop trigger if exists transactionUpdate;
Delimiter //
Create trigger transactionUpdate
After update on panier
For each row
Begin
    update produit
    set qteproduit = qteproduit - new.quantite
    where idproduit = new.idproduit;
End //
Delimiter ;

Drop trigger if exists transactionUpdate2;
Delimiter //
Create trigger transactionUpdate2
After update on savepanier
For each row
Begin
    update produit
    set qteproduit = qteproduit - new.quantite
    where idproduit = new.idproduit;
End //
Delimiter ;

Drop trigger if exists transactionDelete;
Delimiter //
Create trigger transactionDelete
After delete on panier
For each row
Begin
    update produit
    set qteproduit = qteproduit + old.quantite
    where idproduit = old.idproduit;
End //
Delimiter ;

/*
Drop trigger if exists transactionDelete2;
Delimiter //
Create trigger transactionDelete2
After delete on savepanier
For each row
Begin
    update produit
    set qteproduit = qteproduit + old.quantite
    where idproduit = old.idproduit;
End //
Delimiter ;
*/

Drop trigger if exists calculInsert;
Delimiter //
Create trigger calculInsert
After insert on panier
For each row
Begin
    update commande co
    set montantTotalHT = montantTotalHT + (
            select sum(prixproduit * new.quantite)
            from produit p
            where p.idproduit = new.idproduit
            group by new.numcommande
        ),
    TVA = montantTotalHT * 0.20,
    montantTotalTTC = TVA + montantTotalHT
    where numcommande = new.numcommande;
End //
Delimiter ;

Drop trigger if exists calculInsert2;
Delimiter //
Create trigger calculInsert2
After insert on savepanier
For each row
Begin
    update savecommande co
    set montantTotalHT = montantTotalHT + (
            select sum(prixproduit * new.quantite)
            from produit p
            where p.idproduit = new.idproduit
            group by new.numcommande
        ),
    TVA = montantTotalHT * 0.20,
    montantTotalTTC = TVA + montantTotalHT
    where numcommande = new.numcommande;
End //
Delimiter ;

Drop trigger if exists calculUpdate;
Delimiter //
Create trigger calculUpdate
Before update on panier
For each row
Begin
    declare qte int(3);
    declare mth decimal(10,2) default 0;
    if new.quantite < old.quantite
        then
            set qte = old.quantite - (
                    select new.quantite
                    from panier
                    where numcommande = old.numcommande
                    and idproduit = old.idproduit
                );
            select sum(prixproduit * qte) into mth
            from produit p
            where p.idproduit = old.idproduit;
            update commande
            set montantTotalHT = montantTotalHT - mth,
            TVA = montantTotalHT * 0.20,
            montantTotalTTC = montantTotalHT + TVA
            where numcommande = old.numcommande;
    else
        set qte = (
                select new.quantite
                from panier
                where numcommande = old.numcommande
                and idproduit = old.idproduit
            ) - old.quantite;
        select sum(prixproduit * qte) into mth
        from produit p
        where p.idproduit = old.idproduit;
        update commande
        set montantTotalHT = montantTotalHT + mth,
        TVA = montantTotalHT * 0.20,
        montantTotalTTC = montantTotalHT + TVA
        where numcommande = new.numcommande;
    end if ;
End //
Delimiter ;

Drop trigger if exists calculUpdate2;
Delimiter //
Create trigger calculUpdate2
Before update on savepanier
For each row
Begin
    declare qte int(3);
    declare mth decimal(10,2) default 0;
    if new.quantite < old.quantite
        then
            set qte = old.quantite - (
                    select new.quantite
                    from savepanier
                    where numcommande = old.numcommande
                    and idproduit = old.idproduit
                );
            select sum(prixproduit * qte) into mth
            from produit p
            where p.idproduit = old.idproduit;
            update savecommande
            set montantTotalHT = montantTotalHT - mth,
            TVA = montantTotalHT * 0.20,
            montantTotalTTC = montantTotalHT + TVA
            where numcommande = old.numcommande;
    else
        set qte = (
                select new.quantite
                from savepanier
                where numcommande = old.numcommande
                and idproduit = old.idproduit
            ) - old.quantite;
        select sum(prixproduit * qte) into mth
        from produit p
        where p.idproduit = old.idproduit;
        update savecommande
        set montantTotalHT = montantTotalHT + mth,
        TVA = montantTotalHT * 0.20,
        montantTotalTTC = montantTotalHT + TVA
        where numcommande = new.numcommande;
    end if ;
End //
Delimiter ;

Drop trigger if exists calculDelete;
Delimiter //
Create trigger calculDelete
Before delete on panier
For each row
Begin
    update commande
    set montantTotalHT = montantTotalHT - (
            select sum(prixproduit * old.quantite)
            from produit p
            where p.idproduit = old.idproduit
        ),
    TVA = montantTotalHT * 0.20,
    montantTotalTTC = montantTotalHT + TVA
    where numcommande = old.numcommande;
End //
Delimiter ;

Drop trigger if exists calculDelete2;
Delimiter //
Create trigger calculDelete2
Before delete on savepanier
For each row
Begin
    update savecommande
    set montantTotalHT = montantTotalHT - (
            select sum(prixproduit * old.quantite)
            from produit p
            where p.idproduit = old.idproduit
        ),
    TVA = montantTotalHT * 0.20,
    montantTotalTTC = montantTotalHT + TVA
    where numcommande = old.numcommande;
End //
Delimiter ;

Drop procedure if exists insertCommande;
Delimiter //
Create procedure insertCommande(in p_idclient int(11), in p_datelivraison datetime, in p_idproduit int(11), in p_quantite int(3))
Begin
    declare p_numcommande int(8);
    insert into commande values (null, p_idclient, null, null, 0, 0, 0, sysdate(), p_datelivraison, p_idproduit);
    insert into savecommande values (null, p_idclient, null, null, 0, 0, 0, sysdate(), p_datelivraison, p_idproduit);
    select numcommande into p_numcommande
    from savecommande
    where idclient = p_idclient and idproduit = p_idproduit;
    insert into panier values (p_numcommande, p_idproduit, p_quantite, p_idclient);
    insert into savepanier values (p_numcommande, p_idproduit, p_quantite, p_idclient);
End //
Delimiter ;

call insertCommande(4, sysdate(), 1, 1);
call insertCommande(4, sysdate(), 2, 1);

select * from commande;
select * from panier;

Drop procedure if exists deleteCommande;
Delimiter //
Create procedure deleteCommande(in p_numcommande int(8), in p_idproduit int(11), in p_idclient int(11))
Begin
    delete from commande where numcommande = p_numcommande and idproduit = p_idproduit and idclient = p_idclient;
    delete from savecommande where numcommande = p_numcommande and idproduit = p_idproduit and idclient = p_idclient;
    delete from panier where numcommande = p_numcommande and idproduit = p_idproduit and idclient = p_idclient;
    delete from savepanier where numcommande = p_numcommande and idproduit = p_idproduit and idclient = p_idclient;
End //
Delimiter ;

Create table facture (
    idfacture int(11) not null auto_increment,
    datefacture datetime,
    idclient int(11) not null,
    idproduit int(11) not null,
    numcommande int(8) not null,
    primary key (idfacture),
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade,
    foreign key (idproduit) references produit (idproduit)
    on update cascade
    on delete cascade,
    foreign key (numcommande) references savecommande (numcommande)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vfacture(idfacture, datefacture, idclient, nom, email, adresse, cp, ville, pays, idproduit, produit, prix, montantTotalHT, montantTotalTTC, TVA, datecommande, datelivraison, numcommande, mode_payement, etat, quantite)
as select f.idfacture, date_format(f.datefacture, '%d/%m/%Y %H:%i'), c.idclient, c.nom, c.email, c.adresse, c.cp, c.ville, c.pays, p.idproduit, p.nomproduit, p.prixproduit, co.montantTotalHT, co.montantTotalTTC, co.TVA, date_format(co.datecommande, '%d/%m/%Y %H:%i'), date_format(co.datelivraision, '%d/%m/%Y %H:%i'), co.numcommande, co.mode_payement, co.etat, pa.quantite
from facture f inner join client c
on f.idclient = c.idclient
inner join produit p
on f.idproduit = p.idproduit
inner join savecommande co
on f.numcommande = co.numcommande
inner join savepanier pa
on f.numcommande = pa.numcommande
group by f.numcommande;

Drop procedure if exists insertFacture;
Delimiter //
Create procedure insertFacture(in p_idclient int(11), in p_idproduit int(11), in p_numcommande int(8))
Begin
    insert into facture values (null, sysdate(), p_idclient, p_idproduit, p_numcommande);
End //
Delimiter ;

Create table message (
    idmessage int(11) not null auto_increment,
    id_exp int(11) not null,
    id_dest int(11) not null,
    date_envoi datetime,
    contenu longtext,
    lu int not null default 0,
    primary key (idmessage, id_exp, id_dest),
    foreign key (id_dest) references client (idclient)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Insert into message values
(null, 1, 2, sysdate(), 'Coucou, ca va ?', 1),
(null, 1, 3, sysdate(), 'AAaaaaaa', 1),
(null, 1, 1, sysdate(), 'Rappel RDV', 0);

Create or replace view vmessage(idmessage, id_exp, expediteur, id_dest, destinataire, date_envoi, contenu, lu)
as select m2.idmessage, m1.id_exp, a.nom, m2.id_dest, b.nom, date_format(m1.date_envoi, '%d/%m/%Y %H:%i'), m2.contenu, m2.lu
from client a, client b, message m1, message m2
where m1.id_exp = a.idclient
and m2.id_dest = b.idclient
and m1.date_envoi = m2.date_envoi
group by m2.idmessage;

Create table admin (
    idadmin int(11) not null auto_increment,
    email varchar(50) UNIQUE,
    mdp varchar(50),
    droit int not null default 0,
    primary key (idadmin)
) ENGINE=InnoDB, CHARSET=utf8;

Drop trigger if exists modifierMdp;
Delimiter //
Create trigger modifierMdp
Before insert on admin
For each row
Begin
    set new.mdp = sha1(new.mdp);
End //
Delimiter ;

Insert into admin values (null, 'admin@gmail.com', '123', 1);

Create table commentaire (
    idcom int(11) not null auto_increment,
    idproduit int(11) not null,
    idclient int(11) not null,
    contenu longtext not null,
    client_id int(11) not null,
    dateheurepost datetime,
    primary key (idcom),
    foreign key (idproduit) references produit (idproduit)
    on update cascade
    on delete cascade,
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Create or replace view vcommentaire(idcom, idproduit, idclient, contenu, client_id, dateheurepost) 
as select co.idcom, p.idproduit, cl.nom, co.contenu, co.client_id, date_format(co.dateheurepost, '%d/%m/%Y %H:%i')
from commentaire co inner join produit p
on co.idproduit = p.idproduit
inner join client cl
on co.idclient = cl.idclient
group by co.idcom;

Create table BDD (
    nom_bdd varchar(60) not null,
    nb_views int,
    nb_triggers int,
    nb_procedures int,
    nb_functions int,
    primary key (nom_bdd)
) ENGINE=InnoDB;

Drop procedure if exists statsbdd;
Delimiter //
Create procedure statsbdd(nomBdd varchar(60))
Begin
    declare nbview, nbtrigger, nbprocedure, nbfunction int;
    
    select count(*) into nbview 
    from information_schema.views
    where TABLE_SCHEMA = nomBdd;

    select count(*) into nbtrigger
    from information_schema.triggers
    where TRIGGER_SCHEMA = nomBdd;

    select count(*) into nbprocedure
    from information_schema.ROUTINES
    where ROUTINE_SCHEMA = nomBdd
    and ROUTINE_TYPE = 'procedure';

    select count(*) into nbfunction
    from information_schema.ROUTINES
    where ROUTINE_SCHEMA = nomBdd
    and ROUTINE_TYPE = 'function';

    insert into BDD values (nomBdd, nbview, nbtrigger, nbprocedure, nbfunction);
End //
Delimiter ;

Select * from BDD;

Create or replace view vstatsproduits as
SELECT
    ifnull(nomproduit, 'TOTAL') nomproduit,
    SUM(IF(libelle='Autoradio', prixproduit, "")) AS 'autoradio',
    SUM(IF(libelle='GPS', prixproduit, "")) AS 'gps',
    SUM(IF(libelle='Aide à la conduite', prixproduit, "")) AS 'aide_a_la_conduite',
    SUM(IF(libelle='Haut-parleurs', prixproduit, "")) AS 'haut_parleurs',
    SUM(IF(libelle='Kit mains-libre', prixproduit, "")) AS 'kit_mains_libre',
    SUM(IF(libelle='Amplificateur', prixproduit, "")) AS 'amplificateurs'
FROM vproduit
GROUP BY nomproduit with rollup;

Select * from vstatsproduits;

Create table question (
    idquestion int(11) not null auto_increment,
    enonce longtext,
    primary key (idquestion)
) ENGINE=InnoDB, CHARSET=utf8;

Insert into question values
(null, "Quelle est la personnalité historique que vous préférez ?"),
(null, "Quel est votre acteur, musicien ou artiste favori ?"),
(null, "Dans quelle ville se sont rencontrés vos parents ?"),
(null, "Quel est le nom de famille de votre professeur d'enfance préféré ?");

Create table reponse (
    idreponse int(11) not null auto_increment,
    idquestion int(11) not null,
    reponse text,
    idclient int(11) not null,
    primary key (idreponse),
    foreign key (idquestion) references question (idquestion)
    on update cascade
    on delete cascade,
    foreign key (idclient) references client (idclient)
    on update cascade
    on delete cascade
) ENGINE=InnoDB, CHARSET=utf8;

Insert into reponse values
(null, 2, 'Tom Hanks', 1),
(null, 3, 'Paris', 2),
(null, 1, 'Napoléon', 3);

Create or replace view mesQuestions(idreponse, enonce, reponse, idclient, email)
as select r.idreponse, q.enonce, r.reponse, c.idclient, c.email
from reponse r inner join question q
on r.idquestion = q.idquestion
inner join client c
on r.idclient = c.idclient
group by r.idreponse;

select * from mesQuestions;

Drop procedure if exists insertReponse;
Delimiter //
Create procedure insertReponse(in p_enonce longtext, in p_reponse text, in p_email varchar(50), in p_mdp varchar(255))
Begin
    declare p_idquestion int(11);
    declare p_idclient int(11);

    select idquestion into p_idquestion
    from question
    where enonce = p_enonce;

    select idclient into p_idclient
    from client
    where email = p_email and mdp = sha1(p_mdp);

    insert into reponse values (null, p_idquestion, p_reponse, p_idclient);
End //
Delimiter ;

Create or replace view TP (libelle, nomproduit) as
select t.libelle, p.nomproduit
from type t, produit p
where t.idtype = p.idtype
order by t.libelle;

call statsbdd('filelec');

select * from BDD;
