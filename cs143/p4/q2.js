db.laureates.aggregate([
    {
        $unwind: "$nobelPrizes"
    },
    {
        $unwind: "$nobelPrizes.affiliations"
    },
    {
        $match: {
            "nobelPrizes.affiliations.name.en": "CERN"
        }
    },
    {
        $project: {
            _id: 0,
            "country": "$nobelPrizes.affiliations.country.en"
        }
    },
    {
        $limit: 1
    }
])

