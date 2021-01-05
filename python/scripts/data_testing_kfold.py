import json
import sklearn.datasets
import pandas as pd

tf = []

with open(f'dataset_feature.json', 'r') as f:
    tf = json.load(f)
tf.append('target_label')

# read from file csv
data = pd.read_csv('dataset.csv', header=None)
data.columns = tf
 
# Import library for k-fold
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import GaussianNB
from sklearn.model_selection import StratifiedKFold
from sklearn import metrics

#Create a Gaussian Classifier and K-FOLD
gnb = GaussianNB()
kfold = StratifiedKFold(n_splits=10, shuffle=True, random_state=827)
accur = []
for train_index, test_index in kfold.split(data.loc[:,data.columns!='target_label'], data['target_label']): 

    # Split train and test
    X_train, X_test = data.loc[train_index, data.columns!='target_label'], data.loc[test_index, data.columns!='target_label']
    y_train, y_test = data.loc[train_index, 'target_label'], data.loc[test_index, ['target_label']]

    gnb.fit(X_train, y_train.values.ravel())
    y_pred = gnb.predict(X_test)

    # Model Accuracy, how often is the classifier correct?
    accur.append(metrics.accuracy_score(y_test, y_pred)*100)
        
for i,score in enumerate(accur, start=1):
    print(f'Fold {i} - Accuracy = %.2f%% ' % (score))
    
print('Rata-rata akurasi = %.2f%%' % (sum(accur)/len(accur)))