import pandas as pd
import numpy as np
import os
from haversine import haversine
import math

def roc(n):
    a = 0
    b = 0
    c = 0
    d = 0
    for i in range(len(result)):
        if((result["RI"].values[i] >= n) and (pn_grid["pn"].values[i] == 1)):
            a += 1
        elif((result["RI"].values[i] >= n) and (pn_grid["pn"].values[i] == 0)):
            b += 1
        elif((result["RI"].values[i] < n) and (pn_grid["pn"].values[i] == 1)):
            c += 1
        else:
            d += 1
    return (a*d - b*c)/((a + c)*(b + d)) 

os.chdir(r"C:\Users\klims\Desktop\risk_assessment")

# Flexible Parameters
r = 100
min_magnitude_use = 2
LeastMagPredict = 6
cutting_day = 0.7 # '24-May-2005'
digit_num = 5

# Step 1: Load Study Area & Earthquake Data
study_area = pd.read_csv('Input/Study-area.txt', sep='\t', names=["Long", "Lat", "Depth"], header=None)
eq_data = pd.read_csv('Input/EQ-data.txt', sep='\t', names=["Long", "Lat", "Year", "Month", "Date", "Magnitude", "Depth", "Hour", "Minute", "Second"], header=None)

if(type(cutting_day) == float):
    # for ratio
    train_size = int(len(eq_data)*cutting_day)
elif(type(cutting_day) == str):
    pass
else:
    #raise
    pass

cbs = np.zeros(len(study_area))
train_data = eq_data.iloc[:train_size]
test_data = eq_data.iloc[train_size:]
result = study_area.assign(RI=0)

for i in range(len(study_area)):
    print("pt. " + str(i) + " out of " + str(len(study_area)) + " points")
    sr_energy = 0
    study_area_coord = (study_area["Lat"].values[i], study_area["Long"].values[i])
    for j in range(len(train_data)):
        eq_coord = (train_data["Lat"].values[j], train_data["Long"].values[j])
        dis = haversine(study_area_coord, eq_coord)
        if((r >= dis) and (train_data["Magnitude"].values[j] > min_magnitude_use)):
            sr_energy += math.e**(5.24 + (1.44*train_data["Magnitude"].values[j]))
    cbs[i] = math.sqrt(sr_energy)

result["RI"] = cbs/max(cbs)

pn_grid = study_area.assign(pn=0)
for i in range(len(pn_grid)):
    print("pt. " + str(i) + " out of " + str(len(study_area)) + " points")
    study_area_coord = (study_area["Lat"].values[i], study_area["Long"].values[i])
    for j in range(len(test_data)):
        eq_coord = (test_data["Lat"].values[j], test_data["Long"].values[j])
        dis = haversine(study_area_coord, eq_coord)
        if((r >= dis) and (test_data["Magnitude"].values[j] > LeastMagPredict)):
            pn_grid["pn"].values[i] = 1
            break

# ROC calculation
start_roc = 0
stop_roc = 1
max_roc = [0, 0]
for i in range(digit_num):
    n = start_roc
    while(n<=stop_roc):
        val = roc(n)
        if(val>=max_roc[1]):
            max_roc[0] = n
            max_roc[1] = val
            print(max_roc)
        n += (10**(-(i+1)))
    
    # New start and stop values
    start_roc = max_roc[0]-(10**(-(i+1)))
    stop_roc = max_roc[0]+(10**(-(i+1)))

print("High risk for earthquake is when more than " + str(max_roc*5))
result["RI"] = result["RI"]*5
