import express from 'express';
import cors from 'cors';
import fetch from 'node-fetch';
import { createClient } from '@supabase/supabase-js';
import path from 'path';
import { fileURLToPath } from 'url';

const app = express();
app.use(cors());
app.use(express.json());

// إعدادات Supabase
const supabaseUrl = 'https://rjqbbeyzyvynlapmwpiy.supabase.co';
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJqcWJiZXl6eXZ5bmxhcG13cGl5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTY1Mzg1NTAsImV4cCI6MjA3MjExNDU1MH0.h1MdgTuxhfYHme6DzX5P6FZDs7q6Ec3WfnXL5mDRZCY';
const supabase = createClient(supabaseUrl, supabaseKey);

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// صفحة الترحيب
app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
});

// تسجيل الزوار
app.post('/logger', async (req, res) => {
  const ip = req.headers['x-forwarded-for'] || req.socket.remoteAddress;
  const data = {
    ip,
    user_agent: req.body.userAgent,
    language: req.body.language,
    platform: req.body.platform,
    screen: req.body.screen,
    timezone: req.body.timezone,
    memory: req.body.memory,
    cores: req.body.cores,
    timestamp: new Date().toISOString()
  };

  const { error } = await supabase.from('visitors').insert([data]);
  if (error) return res.status(500).json({ status: 'error', details: error });
  res.json({ status: 'success' });
});

const port = process.env.PORT || 3000;
app.listen(port, () => console.log(`Server running on port ${port}`));
