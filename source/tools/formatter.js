const fs = require('fs');
const path = require('path');
var xmlFormatter = require('xml-formatter');

const main = async () => {
  try {
    fileName = process.argv[2];
    if (fileName == undefined) return false;
    const dataAsString = await fs.readFileSync(path.resolve(fileName), { encoding: 'utf-8' });
    var formattedXml = xmlFormatter(dataAsString);

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
