from nlp_id.postag import PosTag
import nltk

nltk.download('punkt')

text = 'Inisialisasi POST TAGGING'

postagger = PosTag()
text = postagger.get_pos_tag(text)
print('DONE!')