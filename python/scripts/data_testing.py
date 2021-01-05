import json
import sklearn.datasets
import pandas as pd

tf = []
count = 400

with open(f'dataset_feature.json', 'r') as f:
    tf = json.load(f)

tf.append('target_label')
# read from file csv
data = pd.read_csv('dataset.csv', header=None)
data.columns = tf
 
# Import train_test_split function
from sklearn.model_selection import train_test_split

# Split dataset into training set and test set
X_train, X_test, y_train, y_test = train_test_split(data.loc[:,data.columns!='target_label'], 
data['target_label'], test_size=0.25, random_state=145) # 75% training and 25% test

#Import Gaussian Naive Bayes model
from sklearn.naive_bayes import GaussianNB

#Create a Gaussian Classifier
gnb = GaussianNB()

#Train the model using the training sets
gnb.fit(X_train, y_train.values.ravel())

#Predict the response for test dataset
y_pred = gnb.predict(X_test)

#Import scikit-learn metrics module for accuracy calculation
from sklearn import metrics

# Model Accuracy,
print("Accuracy:",metrics.accuracy_score(y_test, y_pred))
