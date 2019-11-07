const { Client } = require('discord.js');
const { RichEmbed } = require('discord.js');
const { config } = require("dotenv");

const msg_name = process.argv[2];
const msg_dateAvailible = process.argv[3];
const msg_dateEnd = process.argv[4];

var channelName = "moodle"; //change le nom du chan

const client = new Client({
    disableEveryone: true
});


config({
    path: __dirname + "/config/.env"
});

client.on('ready', () => {
    console.log('I am ready!');
  
    const embed = new RichEmbed()
        .setTitle(msg_name)
        .setColor(0xFF0000)
        .setDescription('Date de début : '+ msg_dateAvailible +' \nDate de fin : ' + msg_dateEnd);

        const channel = client.channels.find(ch => ch.name === channelName);
        channel.send(embed)
        .then(() => client.destroy());

  });

//Change ton token de bot
client.login(process.env.TOKEN);