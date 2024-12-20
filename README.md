Aplicació per guardar contrasenyes en PHP CRUD.


Base de dades:

DB - projecte

TAULA-usuaris
	u_id INT
	u_name VARCHAR
	u_email VARCHAR
	u_pass VARCHAR

TAULA-passwd
	p_id INT
	u_id INT
	p_web VARCHAR
	p_user VARCHAR
	p_url VARCHAR
	p_password VARCHAR
	p_data_caduc VARCHAR
	p_fortalesa INT
