#!/bin/python3

import math
import os
import random
import re
import sys

#
# Complete the 'minimumBribes' function below.
#
# The function accepts INTEGER_ARRAY q as parameter.
#

def minimumBribes(q):
    totalBribe = 0
    for i in range(len(q)-1):
        bribeCount = 0
        # print("'", i, q[i], totalBribe, "'")
        if(q[i]<i):
            continue
        for j in range(n-i):
            if(q[i]>q[j+i]):
                bribeCount += 1
            if (bribeCount > 2) :
                print('Too chaotic')
                return None
        totalBribe += bribeCount
    print(totalBribe)


if __name__ == '__main__':
    t = int(input().strip())

    for t_itr in range(t):
        n = int(input().strip())

        q = list(map(int, input().rstrip().split()))

        minimumBribes(q)
