const fs = require('fs');

let file = fs.readFileSync("/home/cs143/data/nobel-laureates.json");
let data = JSON.parse(file);

let lstream = fs.createWriteStream("laureates.import")

for (l of data.laureates) {
    lstream.write(JSON.stringify(l) + "\n");
}

lstream.end();