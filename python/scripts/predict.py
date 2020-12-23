# Library
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import GaussianNB
import pandas as pd
import json
import sys
import os

def predict(val):
    
    # Create empty variable
    tweet = {}
    data_pred = []

    # Open tweet data
    with open(f'temp/{val}.json', 'r') as f:
        temp = json.load(f)
    tweet['data'] = temp
    data_pred.append(temp)

    # Open feature word
    with open(f'scripts/dataset_feature.json', 'r') as f:
        feature = json.load(f)
    feature.append('target_label')

    # Open dataset file csv
    data = pd.read_csv('scripts/dataset.csv', header=None)
    data.columns = feature

    # Prediction
    # -- Split dataset into training set and test set
    X_train, X_test, y_train, y_test = train_test_split(data.loc[:,data.columns!='target_label'], data['target_label'], test_size=0.25, random_state=145) # 75% training and 25% test

    # -- Create a Gaussian Classifier
    gnb = GaussianNB()

    # -- Train the model using the training sets
    gnb.fit(X_train, y_train.values.ravel())

    # -- Predict the target_label
    prediction = gnb.predict(data_pred)

    # Delete file temporary
    os.remove(f'temp/{val}.json')

    # Add prediction result to json
    tweet['result'] = int(prediction[0])

    # Save status
    tweet['message'] = 'success'
        
    return tweet