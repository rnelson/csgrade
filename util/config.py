from xml.etree import ElementTree
import os
import sys

class Config:
	def getLab(self):
		return {
			'complete':	 False,
			'num':		 '',
			'name':		 '',
			'shortname': '',
			'numparts':	 '',
			'dir':		 '',
			'parts':	 None,
			'numparts':	 0
		}

	def getLabPart(self):
		return {
			'name':		 '',
			'source':	 '',
			'sources':	 None,
			'basefiles': [],
			'binary':	 '',
			'type':		 '',
			'matchtype': '',
			'solbin':	 '',
			'soltxt':	 '',
			'solution':	 '',
			'Makefile':	 '',
			'mossglob':	 ''
		}
		
	def __init__(self, filename='csgrade.test.conf.xml'):
		"""Creates a new Config object and parses the config"""
		if not os.path.exists(filename):
			print 'warning: config file "' + filename + '" does not exist'
		else:
			try:
				# Script constants
				self.name = 'csgrade test/grade script'
				self.version = '0.1'
				self.author = 'Ross Nelson <http://github.com/rnelson>'
				self.copyright = 'Copyright (C) 2010-2011 Ross Nelson'
				self.license = 'BSD License (http://opensource.org/licenses/bsd-license.php)'
				
				# Load the file into the XML parser
				xml = ElementTree.parse(filename)
				root = xml.getroot()
				
				# Grab the global configuration stuff
				self.instructor = root.find('instructor').text
				self.gradingPassword = root.find('gradingPassword').text
				self.compilerBinary = root.find('compilerBinary').text
				self.makeBinary = root.find('makeBinary').text
				self.homeDirectory = root.find('homeDirectory').text
				self.submittedFilesRoot = root.find('submittedFilesRoot').text
				self.mossBinary = root.find('mossBinary').text
				self.mossLanguage = root.find('mossLanguage').text
				
				# Grab each lab
				self.labs = []
				labNodes = root.findall('lab')
				for labNode in labNodes:
					lab = self.getLab()
					lab['num'] = labNode.find('number').text
					lab['name'] = labNode.find('name').text
					lab['shortname'] = labNode.find('shortName').text
					lab['dir'] = labNode.find('directory').text
					
					if labNode.find('complete').text == 'true':
						lab['complete'] = True
					else:
						lab['complete'] = False
					
					partNodes = labNode.findall('part')
					if len(partNodes) > 0:
						lab['parts'] = []
					
					for partNode in partNodes:
						# Grab the part
						part = self.getLabPart()
						part['name'] = partNode.find('name').text
						part['source'] = partNode.find('mainSource').text
						part['binary'] = partNode.find('binary').text
						part['type'] = partNode.find('type').text
						part['matchtype'] = partNode.find('matchType').text
						part['solbin'] = partNode.find('solutionBinary').text
						part['soltxt'] = partNode.find('solutionText').text
						part['solution'] = partNode.find('solution').text
						part['Makefile'] = partNode.find('makefile').text
						part['mossglob'] = partNode.find('mossGlob').text
						
						# For sources, we may have multiple nodes
						sourceNodes = partNode.findall('source')
						if len(sourceNodes) > 0:
							part['sources'] = []
							for sourceNode in sourceNodes:
								part['sources'].append(sourceNode.text)
						
						# Same with MOSS base files
						mossBaseFiles = partNode.findall('mossBaseFile')
						if len(mossBaseFiles) > 0:
							for mossBaseFile in mossBaseFiles:
								part['basefiles'].append(mossBaseFile.text)
						
						# Add the part to the lab we created
						lab['parts'].append(part)
					
					# Add the lab to the list
					self.labs.append(lab)
			
			except Exception, e:
				print 'Error parsing configuration file: %s' % (e)
				sys.exit(-1)
