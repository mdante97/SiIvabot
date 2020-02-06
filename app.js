const Discord = require('discord.js');
const bot = new Discord.Client();

const prefix = '7';
const ownerID = '320369438639652866';
const active = new Map();

bot.on('message', message => {

  let args = message.content.slice(prefix.length).trim().split(' ');
  let cmd = args.shift().toLowerCase();

  if (message.author.bot) {
    return;
  }

  if (!message.content.startsWith(prefix)) {
    return;
  }

  // command handler
  try {
    delete require.cache[require.resolve(`./commands/${cmd}.js`)];

    let ops = {
      ownerID: ownerID,
      active: active
    }

    let commandFile = require(`./commands/${cmd}.js`);
    commandFile.run(bot, message, args, ops);
  } catch(e) {
    console.log(e.stack);
  }

});

bot.on('ready', () => {
  console.log('Bot started')
});
bot.login('NjIwNjY1NjYyODU5MjQ3Njcz.XXaGgQ.TuYgYJb5sZdw8PYbmj5PFi-CDeg');
