import numpy as np
from scipy.stats import percentileofscore

big_result = []


rank1 = [10, 500, 5, 9]
rank2 = [80, 5, 4, 100]

rank1 = int(np.sum(rank1))
rank2 = int(np.sum(rank2))

rank1 = rank1 * 10
rank2 = rank2 * 6

result = rank1 + rank2
big_result.append(result)




rank1_2 = [5, 530, 9, 90]
rank2_2 = [80, 5, 4, 100]

rank1_2 = int(np.sum(rank1_2))
rank2_2 = int(np.sum(rank2_2))

rank1_2 = rank1_2 * 10
rank2_2 = rank2_2 * 6

result_2 = rank1_2 + rank2_2
big_result.append(result_2)


# หาค่าเฉลี่ยของ percentile rank ในแต่ละ rank เพื่อใช้เป็น score
max_value = max(big_result)

# แปลงจำนวนใน big_result เป็นเปอร์เซ็นต์
percentages = [x/max_value*100 for x in big_result]

print([round(x, 2) for x in percentages])