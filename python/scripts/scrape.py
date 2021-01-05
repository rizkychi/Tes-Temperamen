# Library
import sys
import twint
import json
import os

def scrape(val):
    
    # Make temp directory if not exists
    if not os.path.exists('temp'):
        os.makedirs('temp')

    # Create empty variable
    raw   = []
    tweet = []

    # Twint configuration
    c = twint.Config()
    c.Store_object    = True
    c.Hide_output     = True
    c.Limit           = 100
    c.Custom['tweet'] = ['tweet']
    c.Search          = f'from:{val} lang:id'

    # Run Twint
    twint.output.tweets_list.clear()
    twint.run.Search(c)
    raw = twint.output.tweets_list

    # Convert output to json object
    for data in raw:
        tweet.append(data.tweet)

    # Save object to json file
    with open(f'temp/{val}.json', 'w') as f:
        json.dump(tweet, f)

    # Return status
    return {'message': 'success'}