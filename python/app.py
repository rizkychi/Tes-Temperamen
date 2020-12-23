from flask import Flask
from flask_restful import Resource, Api, reqparse
from flask_cors import CORS
from waitress import serve
from scripts.scrape import scrape
from scripts.preprocess import preprocess
from scripts.predict import predict

import pandas as pd
import ast
import os

app = Flask(__name__)
api = Api(app)
CORS(app)

class Scrape(Resource):
    def post(self):
        # Get data from post
        parser = reqparse.RequestParser()  # initialize
        parser.add_argument('user', required=True)  # add arguments
        args = parser.parse_args()  # parse arguments to dictionary

        # log 
        print(f"Starting process (Scrape) for user : {args['user']}")

        # Return status
        return scrape(args['user']), 200 # return message and 200 OK code
    pass

class Preprocess(Resource):
    def post(self):
        # Get data from post
        parser = reqparse.RequestParser()  # initialize
        parser.add_argument('user', required=True)  # add arguments
        args = parser.parse_args()  # parse arguments to dictionary

        # log 
        print(f"Starting process (cleaning) for user : {args['user']}")

        # Check if user exist
        if os.path.exists(f"temp/{args['user']}.json"):
            return preprocess(args['user']), 200 # return data and 200 OK code
        else:
            return { 'message':'failed. user not exist' }, 401 # return message and 401 code
    pass

class Predict(Resource):
    def post(self):
        # Get data from post
        parser = reqparse.RequestParser()  # initialize
        parser.add_argument('user', required=True)  # add arguments
        args = parser.parse_args()  # parse arguments to dictionary

        # log 
        print(f"Starting process (predict) for user : {args['user']}")

        # Check if user exist
        if os.path.exists(f"temp/{args['user']}.json"):
            return predict(args['user']), 200 # return data and 200 OK code
        else:
            return { 'message':'failed. user not exist' }, 401 # return message and 401 code
    pass

api.add_resource(Scrape, '/scrape')  # '/scrape' is our scraping point
api.add_resource(Preprocess, '/preprocess')  # '/preprocess' is our preprocessing point
api.add_resource(Predict, '/predict')  # '/predict' is our predicting point

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)  # run our Flask app in development mode
    # serve(app, host="0.0.0.0", port=80) # deployment mode