import { createClient } from '@supabase/supabase-js';

const supabaseUrl = 'https://rjqbbeyzyvynlapmwpiy.supabase.co';
const supabaseKey = 'PUT_YOUR_KEY_HERE';
const supabase = createClient(supabaseUrl, supabaseKey);

export default async function handler(req, res) {
  if (req.method !== 'POST') return res.status(405).send({ error: 'Method not allowed' });

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
  res.status(201).json({ status: 'success' });
}
