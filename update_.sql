ALTER TABLE fhn_institutions CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL;
ALTER TABLE fhn_institutions CHANGE address address LONGTEXT DEFAULT NULL;

ALTER TABLE fhn_members ADD institution_id INT DEFAULT NULL, ADD share_identification_number VARCHAR(255) DEFAULT NULL;
ALTER TABLE fhn_members ADD CONSTRAINT FK_D1BD1FCE10405986 FOREIGN KEY (institution_id) REFERENCES fhn_institutions (id);
CREATE INDEX IDX_D1BD1FCE10405986 ON fhn_members (institution_id);