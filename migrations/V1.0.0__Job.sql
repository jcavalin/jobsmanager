CREATE TABLE app.user (
    id SERIAL PRIMARY KEY NOT NULL,
    email VARCHAR(50) NOT NULL,
    role VARCHAR(10) NOT NULL
);

CREATE TABLE app.job (
    id SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id)
        REFERENCES user (id)
        ON DELETE RESTRICT
);
