const fs = require('fs');
const path = require('path');

const main = async () => {
  try {
    const dataAsString = await fs.readFileSync(path.resolve(`data/package.json`), { encoding: 'utf-8' });
    const dataAsJson = JSON.parse(dataAsString);
    var readmeHeader = "# Package List - Carik Microservice Ecosystem";
    var readmeContent = "\n";
    readmeHeader += "\nDaftar paket yang tersedia di dalam Ecosystem."

    Object.keys(dataAsJson.packages).forEach(function (category){
      readmeContent += "\n\n## "+category;
      readmeContent += "\n| Package | Description | Author |";
      readmeContent += "\n|---|---|---|";
      packages = dataAsJson.packages[category];
      Object.keys(packages).forEach(function (packageKey){
        packageName = packages[packageKey]['name'];
        description = packages[packageKey]['description'];
        patterns = packages[packageKey]['pattern'];
        author = packages[packageKey]['author'];
        //if (author==undefined) author = "";
        author = (author==undefined) ? "" : author;
        patternText = '<br>Keyword:';
        if (patterns != undefined){
          Object.keys(patterns).forEach(function (pattern){
            patternText += '<br />- '+patterns[pattern];
          });  
        }
        patternText = patternText.replace(/\|/g, '\\|');
        url = "../data/"+category+"/"+packageName;
        readmeContent += "\n|["+packageName+"]("+url+")|"+description+patternText+"|"+author+"|";
      });      
    });

    readme = readmeHeader + readmeContent;
    readme += "\n\n___\n_*File ini digenerate otomatis. **Jangan** diedit manual_";

    // write to file
    fs.writeFile(path.resolve('docs/package-list.md'), readme, function (err){
      if (err){
        return console.log('❌ Error write file package-list.md', err);
      }
      console.log('✅ Success write file PackageList.md');
    });

  } catch (error) {
    console.error('❌ Error build package list', error);
  }
}

main();
