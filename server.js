// server.js

const express = require('express');
const fetch = require('node-fetch');

const app = express();
const PORT = process.env.PORT || 3000; // Use the environment port or 3000 if not specified

app.use(express.json());

app.get('/eventsInfo/:id', async (req, res) => {
    const { id } = req.params;
    try {
        const response = await fetch(`https://revencu.com/eventsInfo/${id}/1?json=1`);
        const data = await response.json();
        res.json(data);
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: 'Internal server error' });
    }
});

app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
