# ---------------- Cleaning ---------------- #
import re
def cleaning(tweet):

    # 1. Case folding : Convert text to lowercase
    tweet = tweet.lower()

    # 2. Remove unicode
    tweet = tweet.encode('ascii', 'ignore').decode('ascii')

    # 3. Remove mention
    tweet = re.sub(r'@[^\s]+', '', tweet)

    # 4. Remove url
    tweet = re.sub(r'((www[^\s]+)|(http[s]?://[^\s]+)|(pic.twitter[^\s]+))', '', tweet)

    # 5. Remove hashtag
    tweet = re.sub(r'#[^\s]+', '', tweet)

    # 6. Remove number
    tweet = re.sub(r'[\d]', ' ', tweet)

    # 7. Remove punctuation
    tweet = re.sub(r'[^\w\s]', ' ', tweet)

    # 8. Remove less than 3 character
    tweet = re.sub(r'\b\w{1,2}\b', ' ', tweet)

    # 9. Remove space
    tweet = re.sub(r'[\s]+', ' ', tweet)

    # 10. Remove space at the beginning and the end of text
    tweet = tweet.strip()

    return tweet

# ---------------- Tokenization ---------------- #
from nltk.tokenize import word_tokenize
def tokenization(tweet):
    return word_tokenize(tweet)

# ---------------- Stemming ---------------- #
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
def stemming(tweet):
    # create stemmer
    factory = StemmerFactory()
    stemmer = factory.create_stemmer()
    return stemmer.stem(tweet)

# ---------------- Stop Word ---------------- #
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory
def stopWord(tweet):
    # create remover
    factory = StopWordRemoverFactory()
    stopword = factory.create_stop_word_remover()
    return stopword.remove(tweet)

# ---------------- POS Tagging ---------------- #  
from nlp_id.postag import PosTag
def posTag(tweet):
    # create tagger
    postagger = PosTag()
    return postagger.get_pos_tag(tweet)

# ---------------- Term Frequency ---------------- #  
def termFreq(document, count):
    totalItem = len(document)
    result = {}
    # count frequency
    for item in document:
        result[item] = document.count(item) / totalItem
    # sort frequency (descending)
    result = sorted(result.items(), key=lambda x: x[1], reverse=True)
    # limit result 
    result = [item for item, freq in result[:count]]
    # result = result[:count]
    return result