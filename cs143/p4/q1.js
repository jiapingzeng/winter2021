db.laureates.find({
    "givenName.en": "Marie",
    "familyName.en": "Curie"
}, {
    "id": 1,
    "_id": 0
})