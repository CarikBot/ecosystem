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
      readmeContent += "\n| Package | Description | Keyword |";
      readmeContent += "\n|---|---|---|";
      packages = dataAsJson.packages[category];
      Object.keys(packages).forEach(function (packageKey){
        packageName = packages[packageKey]['name'];
        description = packages[packageKey]['description'];
        patterns = packages[packageKey]['pattern'];
        author = packages[packageKey]['author'];
        if (author==undefined) author = "";
        patternText = '';
        if (patterns != undefined){
          Object.keys(patterns).forEach(function (pattern){
            patternText += patterns[pattern] + '<br />';
          });  
        }
        patternText = patternText.replace('|', '\\|');
        url = "../data/"+category+"/"+packageName;
        readmeContent += "\n|["+packageName+"]("+url+")|"+description+"<br>author: "+author+"|`"+patternText+"`|";
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
