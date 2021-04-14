const fs = require('fs');
const path = require('path');
const { exit } = require('process');
var xmlFormatter = require('xml-formatter');

const main = async () => {
  try {
    fileName = process.argv[2];
    if (fileName == undefined) return false;
    const dataAsString = await fs.readFileSync(path.resolve(fileName), { encoding: 'utf-8' });
    var formattedXml = xmlFormatter(dataAsString);

    // remove tag
    formattedXml = formattedXml.replace(/ CREATED="[a-zA-Z0-9_]+"/g, '');
    formattedXml = formattedXml.replace(/ MODIFIED="[a-zA-Z0-9_]+"/g, '');

    // write to file
    fs.writeFile(path.resolve(fileName), formattedXml, function (err){
      if (err){
        return console.log(' ❌ Error write file '+fileName, err);
      }
      console.log(' ✅ Success write file '+fileName);
    });

  } catch (error) {
    console.error(' ❌ Error formatting', error);
  }
}

main();
