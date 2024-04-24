import sys
import os
import transformers
from transformers import AutoModel, AutoConfig, Pipeline
from transformers import AutoTokenizer, AutoModelForQuestionAnswering
from transformers import AutoModelForCausalLM, AutoTokenizer
import torch
import json
import requests
import warnings
warnings.filterwarnings('ignore')

# Ce code télécharge le modèle de chatbot DialoGPT de Microsoft et répond à une question donnée en utilisant ce modèle.

# Get the prompt from the command line arguments
prompt = sys.argv[1]  
#Sacctoken = sys.argv[2]
#os.environ['TRANSFORMERS_CACHE'] = './dialogpt'
#os.environ['HUGGINGFACE_TOKEN'] = ''

#print ("<h1>Hello I am your chatbot Road Law expert, here is the answer to your question:</h1>")

# Load the tokenizer and model
tokenizer = AutoTokenizer.from_pretrained("microsoft/DialoGPT-small")
model = AutoModelForCausalLM.from_pretrained("microsoft/DialoGPT-small")

# Your user input
user_input = prompt

# Encode the input and add end of string token
input_ids = tokenizer.encode(user_input + tokenizer.eos_token, return_tensors='pt')

# Generate a response
output = model.generate(input_ids, max_length=1000, pad_token_id=tokenizer.eos_token_id)

# Decode the response
response = tokenizer.decode(output[:, input_ids.shape[-1]:][0], skip_special_tokens=True)

# Print the output
print(f'### User Input:\n{user_input}\n\n### Assistant Output:\n{response}')