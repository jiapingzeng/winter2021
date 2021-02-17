// import fs module to read/write file
const fs = require('fs');

// load JSON data
let file = fs.readFileSync("/home/cs143/data/nobel-laureates.json");
let data = JSON.parse(file)

let laureateStream = fs.createWriteStream("/home/cs143/shared/p3/data/laureate.del");
let personStream = fs.createWriteStream("/home/cs143/shared/p3/data/person.del");
let orgStream = fs.createWriteStream("/home/cs143/shared/p3/data/organization.del");
let placeStream = fs.createWriteStream("/home/cs143/shared/p3/data/place.del");
let affilStream = fs.createWriteStream("/home/cs143/shared/p3/data/affiliation.del");
let prizeStream = fs.createWriteStream("/home/cs143/shared/p3/data/nobel-prize.del");

let places = new Map();
let affils = new Map();
let placeCounter = 1;

let addPlace = (city, country) => {
    // create new place if not exist already, return place id

    let newPlace = JSON.stringify({
        city: city,
        country: country
    });
    if (!places.has(newPlace)) {
        places.set(newPlace, placeCounter++);
        return placeCounter - 1;
    } else {
        return places.get(newPlace);
    }
}

for (l of data.laureates) {

    laureateStream.write(`"${l.id}","${l.orgName ? "organization" : "person"}"\n`);

    if (l.orgName) {
        // organization

        let orgName = l.orgName ? l.orgName.en : null;
        let foundedDate = l.founded ? l.founded.date : null;
        let foundedCity = l.founded && l.founded.place && l.founded.place.city ? l.founded.place.city.en : null;
        let foundedCountry = l.founded && l.founded.place && l.founded.place.country ? l.founded.place.country.en : null;

        orgStream.write(`"${l.id}","${orgName}","${foundedDate}","${addPlace(foundedCity, foundedCountry)}"\n`);
    } else {
        // person

        let givenName = l.givenName ? l.givenName.en : null;
        let familyName = l.familyName ? l.familyName.en : null;
        let birthDate = l.birth ? l.birth.date : null;
        let birthCity = l.birth && l.birth.place && l.birth.place.city ? l.birth.place.city.en : null;
        let birthCountry = l.birth && l.birth.place && l.birth.place.country ? l.birth.place.country.en : null;

        personStream.write(`"${l.id}","${givenName}","${familyName}","${l.gender}","${birthDate}","${addPlace(birthCity, birthCountry)}"\n`);
    }

    for (n of l.nobelPrizes) {

        let category = n.category ? n.category.en : null;
        let motivation = n.motivation ? n.motivation.en : null;

        prizeStream.write(`"${l.id}","${n.awardYear}","${category}","${n.sortOrder}","${n.portion}","${n.prizeStatus}","${n.dateAwarded}","${motivation}","${n.prizeAmount}"\n`);

        if (n.affiliations) {
            for (a of n.affiliations) {
                let affilName = a.name ? a.name.en : null;
                let affilCity = a.city ? a.city.en : null;
                let affilCountry = a.country ? a.country.en : null;

                affilStream.write(`"${l.id}","${affilName}","${addPlace(affilCity, affilCountry)}"\n`);

            }
        }
    }
}

for (p of places.keys()) {
    placeStream.write(`"${places.get(p)}","${JSON.parse(p).city}","${JSON.parse(p).country}"\n`);
}

personStream.end();
orgStream.end();
placeStream.end();
affilStream.end();
prizeStream.end()

// Person(lid [PK], givenName, familyName, gender, birth, pid [FK Place.id])
// Organization(lid [PK], orgName, founded, pid [FK Place.id])
// Place(id [PK], city, country)
// Affiliation(lid [FK Laureates.id], name, pid [FK Place.id])
// NobelPrize(lid [FK Laureates.id], awardYear, category, sortOrder, portion, prizeStatus, dateAwarded, motivation, prizeAmount)