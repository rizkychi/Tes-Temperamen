# Library
from scripts.preprocessing import cleaning, tokenization, stemming, stopWord, posTag, termFreq
import json
import sys

def preprocess(val):

    # Create empty variable
    clean_tweet = []

    # Open tweet data
    with open(f'temp/{val}.json', 'r') as f:
        tweet = json.load(f)

    # Open slang word
    with open(f'scripts/slang.json', 'r') as f:
        slang = json.load(f)

    # Open common word 
    with open(f'scripts/common.json', 'r') as f:
        common = json.load(f)

    # Open feature word
    with open(f'scripts/dataset_feature.json', 'r') as f:
        feature = json.load(f)

    # Preprocessing
    for text in tweet:
        text = cleaning(text)
        text = tokenization(text)
        text = [slang[word] if word in slang else word for word in text]
        text = ' '.join(text)
        text = stemming(text)
        text = stopWord(text)
        text = posTag(text)
        text = [(w,t) for (w,t) in text if t == 'VB' or t == 'ADV' or t == 'JJ' or t.startswith('NN')]
        text = [w for (w,t) in text if w not in common]
        # Tweet merging
        clean_tweet.extend(text)

    # Term Frequency
    term = termFreq(clean_tweet, 400)

    # Convert to binary
    binary = [1 if word in term else 0 for word in feature]

    # Save to json file
    with open(f'temp/{val}.json', 'w') as f:
        json.dump(binary, f)

    return { 'message': 'success' }