from pyspark import SparkContext
from itertools import combinations

sc = SparkContext("local","BookPairs")
lines = sc.textFile("/home/cs143/data/goodreads.user.books")
reviews = lines.flatMap(lambda l: list(combinations(l.split(":")[1].split(","),2)))
mapped = reviews.map(lambda r: (r, 1))
pairs = mapped.reduceByKey(lambda a, b: a+b)
pairs = pairs.filter(lambda p: p[1]>20)
pairs.saveAsTextFile("output")