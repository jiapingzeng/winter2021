SELECT familyName FROM Person GROUP BY familyName HAVING COUNT(*)>4;