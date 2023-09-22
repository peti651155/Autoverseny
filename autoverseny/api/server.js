const express = require('express');
const mysql = require('mysql');

const app = express();
const PORT = 3001;

const dbConnection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'auto_nyilvantartas'
});

dbConnection.connect(err => {
  if (err) {
    console.error('Database connection failed: ' + err.stack);
    return;
  }

  console.log('Connected to database.');
});

app.get('/faster-car', (req, res) => {
  const ids = req.query.ids.split(',').map(id => Number(id));

  if (ids.length < 2 || ids.length > 3) {
    return res.status(400).json({ error: "Két vagy három azonosító szükséges!" });
  }

  dbConnection.query('SELECT * FROM auto WHERE id IN (?)', [ids], (err, results) => {
    if (err) {
      return res.status(500).json({ error: 'Adatbázis hiba!' });
    }

    if (results.length !== ids.length) {
      return res.status(400).json({ error: 'Az egyik vagy több azonosító nem létezik az adatbázisban!' });
    }

    // Ezen a ponton a results változó tartalmazza a kiválasztott autók adatait.
    // Innen folytatva lehet eldönteni, melyik az erősebb autó a megadott logika alapján.
    // Például:
    let theWinnerCar = results[0];
    for (let car of results) {
      let carPerformance = car.Teljesitmeny / car.Suly;
      let winnerPerformance = theWinnerCar.Teljesitmeny / theWinnerCar.Suly;

      if (carPerformance > winnerPerformance || (carPerformance === winnerPerformance && car.Gyartas_ideje > theWinnerCar.Gyartas_ideje)) {
        theWinnerCar = car;
      }
    }

    res.json({ winnerCar: theWinnerCar });
  });
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
