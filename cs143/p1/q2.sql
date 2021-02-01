SELECT first, last
FROM Movie, MovieActor, Actor
WHERE mid=Movie.id
AND aid=Actor.id
AND title='Die Another Day';