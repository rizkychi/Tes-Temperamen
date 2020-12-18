from nlp_id.postag import PosTag

text = 'Inisialisasi POST TAGGING'

postagger = PosTag()
text = postagger.get_pos_tag(text)
print(text)