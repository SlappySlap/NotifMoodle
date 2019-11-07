const { Client, RichEmbed } = require('discord.js');

// Create an instance of a Discord client
const client = new Client();

/**
 * The ready event is vital, it means that only _after_ this will your bot start reacting to information
 * received from Discord
 */

var channelName = "moodle"; //change le nom du chan

client.on('ready', () => {
  console.log('I am ready!');

  const embed = new RichEmbed()
      // Set the title of the field
      .setTitle('A slick little embed')
      // Set the color of the embed
      .setColor(0xFF0000)
      // Set the main content of the embed
      .setDescription('Hello, this is a slick embed!');
    // Send the embed to the same channel as the message
    const channel = client.channels.find(ch => ch.name === channelName);
    channel.send(embed);
});

// Log our bot in using the token from https://discordapp.com/developers/applications/me
client.login('NjQxNzM1MDk5MzA5ODgzNDEy.XcPjWg.VC00gjF9ywyc3RqoTBPYSBd3Anw');