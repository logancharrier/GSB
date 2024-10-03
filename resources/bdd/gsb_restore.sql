use gsb_frais;

CREATE TABLE IF NOT EXISTS comptable (
    idcomptable Char(5) NOT NULL,
    nom char(25) DEFAULT NULL,
    prenom char(25)  DEFAULT NULL,
    login char(25) DEFAULT NULL,
    mdp char(255) DEFAULT NULL,
    PRIMARY KEY (idcomptable)
) ENGINE=InnoDB;

-- Alimentation des données paramètres
INSERT INTO comptable VALUES ('c0uco', 'Charrier', 'Logan', 'l.charrier','test');
