"""
what?
"""
import sys
import pyfpgrowth

transactions = [[1, 2, 5],
                [2, 4],
                [2, 3],
                [1, 2, 4],
                [1, 3],
                [2, 3],
                [1, 3],
                [1, 2, 3, 5],
                [1, 2, 3]
                ]

#minSupp = sys.argv[1]
#minConf = sys.argv[2]

print('hello')

patterns = pyfpgrowth.find_frequent_patterns(transactions, 2)
rules = pyfpgrowth.generate_association_rules(patterns, 0.5)


