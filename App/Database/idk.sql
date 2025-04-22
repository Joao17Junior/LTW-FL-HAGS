-- inicializar.sql
CREATE TABLE User (
    id UUID PRIMARY KEY,
    name VARCHAR(100),
    username VARCHAR(30),
    email VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE Client (
    id UUID PRIMARY KEY,
    FOREIGN KEY (id) REFERENCES User(id)
);

CREATE TABLE Freelancer (
    id UUID PRIMARY KEY,
    FOREIGN KEY (id) REFERENCES User(id)
);

CREATE TABLE Admin (
    id UUID PRIMARY KEY,
    FOREIGN KEY (id) REFERENCES User(id)
);

----------------------------------------------

CREATE TABLE Service (
    service_id UUID PRIMARY KEY,
    freelancer_id UUID,
    FOREIGN KEY (freelancer_id) REFERENCES Freelancer(id),
    title VARCHAR(200),
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    base_price NUMERIC(6,2)
);

CREATE TABLE Conversation (
    conversation_id UUID PRIMARY KEY,
    service_id UUID,
    client_id UUID,
    freelancer_id UUID,
    FOREIGN KEY (service_id) REFERENCES Service(service_id),
    FOREIGN KEY (client_id) REFERENCES Client(id),
    FOREIGN KEY (freelancer_id) REFERENCES Freelancer(id)
);

CREATE TABLE Message (
    message_id UUID PRIMARY KEY,
    conversation_id UUID,
    FOREIGN KEY (conversation_id) REFERENCES Conversation(conversation_id),
    sender UUID,
    FOREIGN KEY (sender) REFERENCES User(id),
    text TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Demand (
    order_id UUID PRIMARY KEY,
    service_id UUID,
    client_id UUID,
    FOREIGN KEY (service_id) REFERENCES Service(service_id),
    FOREIGN KEY (client_id) REFERENCES Client(id),
    completed BOOLEAN DEFAULT FALSE,
    date_completed TIMESTAMP
);

CREATE TABLE Review (
    service_id UUID PRIMARY KEY,
    client_id UUID PRIMARY KEY,
    FOREIGN KEY (service_id) REFERENCES Service(service_id),
    FOREIGN KEY (client_id) REFERENCES Client(id),
    rating INT,
    comment TEXT,
    date_pub TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--ACTIONS--

CREATE TRIGGER update_date_completed
AFTER UPDATE ON Demand
FOR EACH ROW
WHEN NEW.completed = TRUE AND OLD.completed = FALSE
BEGIN
    UPDATE Demand
    SET date_completed = CURRENT_TIMESTAMP
    WHERE order_id = NEW.order_id;
END;



CREATE TRIGGER delete_messages_after_conversation
AFTER DELETE ON Conversation
FOR EACH ROW
BEGIN
    DELETE FROM Message WHERE conversation_id = OLD.conversation_id;
END;



CREATE TRIGGER prevent_user_delete
BEFORE DELETE ON User
FOR EACH ROW
WHEN EXISTS (SELECT 1 FROM Service WHERE freelancer_id = OLD.id)
   OR EXISTS (SELECT 1 FROM Demand WHERE client_id = OLD.id)
BEGIN
    SELECT RAISE(ABORT, 'Cannot delete user linked to services or orders.');
END;



CREATE TRIGGER trg_auto_update_service_time
BEFORE UPDATE ON Service
FOR EACH ROW
BEGIN
    UPDATE Service
    SET updated_at = CURRENT_TIMESTAMP
    WHERE service_id = OLD.service_id;
END;



CREATE TRIGGER trg_auto_update_review_date
BEFORE UPDATE ON Review
FOR EACH ROW
BEGIN
    UPDATE Review
    SET date_pub = CURRENT_TIMESTAMP
    WHERE service_id = OLD.service_id AND client_id = OLD.client_id;
END;
