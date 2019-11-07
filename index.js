const { Client } = require("discord.js");
const { config } = require("dotenv");

const msg_cmd = process.argv[2];
var channelName = "moodle"; //change le nom du chan

const client = new Client({
    disableEveryone: true
});

config({
    path: __dirname + "/config/.env"
});

client.on("ready", () => {
    console.log(`${client.user.username} connected!`);

    client.user.setPresence({
        status: "online",
        game: {
            name: "récolter des données sur moodle",
            type: "PLAYING"
        }
    });
    const channel = client.channels.find(ch => ch.name === channelName);
    channel.send(msg_cmd);

    console.log("Msg send");
    
    client.destroy();

    console.log("bye");
});

//Change ton token de bot
client.login(process.env.TOKEN);

