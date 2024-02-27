const express = require('express');
const app = express();
const cors = require('cors');
const port = 3002;


const initDB = require('./db.js');
const db = initDB();

console.log("Bonjour init");

app.use(express.json());

app.use(cors()); // Permet l’accès à tous le monde

app.use(express.urlencoded({ extended: true }));


app.post('/addUser', (req, res) => {
    const user = { email: req.body.email, nom: req.body.nom, prenom: req.body.prenom, mdp: req.body.mdp };
    const sql = 'INSERT INTO users (email, nom, prenom, mdp) VALUES (?, ?, ?, ?)';
    db.query(sql, [user.email, user.nom, user.prenom, user.mdp], (error, results) => {
        if (error) {
            return res.status(500).send('Erreur lors de l\'insertion de l\'utilisateur');
        }
        res.status(201).send(`utilisateur ajouté avec l'ID: ${results.insertId}`);
    });
});

app.post('/addQuizz', (req, res) => {
    const user = { qname: req.body.qname };
    const sql = 'INSERT INTO qcm (QcmName) VALUES (?)';

    db.query(sql, [user.qname], (error, results) => {
        if (error) {
            return res.status(500).send('Erreur lors de l\'insertion du QCM');
        }
        const qcmId = results.insertId;
        res.status(201).json({ success: true, qcmId: qcmId }); // Renvoyer l'ID du QCM nouvellement créé
    });
});



app.post('/', (req, res) => {
    const quizz = {
        question: req.body.question,
        A: req.body.A,
        B: req.body.B,
        C: req.body.C,
        D: req.body.D,
        userId: req.body.userId, // Assurez-vous que userId est passé dans le corps de la requête
        qcmId: req.body.qcmId // Assurez-vous que qcmId est aussi passé dans le corps de la requête
    };
    const sql = 'INSERT INTO js (question, A, B, C, D, idUser, idQcmName) VALUES (?, ?, ?, ?, ?, ?, ?)';

    db.query(sql, [quizz.question, quizz.A, quizz.B, quizz.C, quizz.D, quizz.userId, quizz.qcmId], (error, results) => {
        if (error) {
            return res.status(500).send('Erreur lors de l\'insertion de la question');
        }
        res.status(201).send(`Question ajoutée avec l'ID: ${results.insertId}`);
    });
});


app.post('/signIn', (req, res) => {
    const { email, mdp } = req.body;
    const query = 'SELECT * FROM users WHERE email = ?';
    db.query(query, [email], (err, result) => {
        if (err) {
            res.status(500).json({ error: 'Erreur interne du serveur' });
            return;
        }

        if (result.length > 0) {
            const user = result[0];
            if (user.mdp === mdp) {
                res.json({ success: true, userId: user.id, nom: user.nom, prenom: user.prenom });
            } else {
                res.status(401).json({ error: 'Mot de passe incorrect' });
            }
        } else {
            res.status(404).json({ error: 'Email non trouvé' });
        }
    });
});


app.listen(port, () => {
    console.log(`Express server listening at http://localhost:${port}`);
});