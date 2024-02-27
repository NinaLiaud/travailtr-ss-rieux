const mysql = require('mysql2');

const initDB = () => {
    const connection = mysql.createConnection({
        host: "localhost",
        port: 3303,
        user: "root",
        password: "root",
        database: "expres"
    });

    connection.connect(error => {
        if (error) throw error;
        console.log("Connected to the MySQL server!");
    });

    return connection;
}

module.exports = initDB; 
