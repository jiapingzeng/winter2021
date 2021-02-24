db.laureates.aggregate([
    {
        $match: {
            "familyName.en": {
                $exists: true
            }
        }
    }, {
        $group: {
            _id: "$familyName.en",
            count: { $sum: 1 }
        }
    }, {
        $match: {
            "count": { $gt: 4 }
        }
    }, {
        $project: {
            _id: 0,
            "familyName": "$_id"
        }
    }
])