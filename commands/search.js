const search = require('yt-search');

exports.run = (client, message, args, ops) => {
  args = 'siivagunner' + args;
  search(args, function(err, res) {
    if (err) {
      return message.channel.send('Sorry, something went wrong');
    }

    let videos = res.videos.slice(0, 5);

    let resp = '';
    for (var i in videos) {
      resp += `**[${parseInt(i)+1}]:** \`${videos[i].title}\`\n`;
    }

    resp += `\n**Choose a number between \`1-${videos.length}\``;

    message.channel.send(resp);

    const filter = m => !isNaN(m.content) && m.content < videos.length+1 && m.content > 0;

  const collector = message.channel.createMessageCollector(filter);

    collector.videos = videos;

    collector.once('collect', function(m) {
      let commandFile = require(`./play.js`);
      message.channel.bulkDelete(3);
      commandFile.run(client, message, [this.videos[parseInt(m.content)-1].url], ops);
    });
  });
}
