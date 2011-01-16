#!/usr/bin/python
from __future__ import with_statement
import getpass
import hashlib
import os
import sys
import subprocess
import tempfile
from config import Config


###########################################################################
##  ABOUT: csgrade grade script v0.1                                     ##
##         Copyright (C) 2010-2011 Ross Nelson                           ##
##                                                                       ##
##  USE:   Build and run the configuration program (under conf/) to      ##
##         configure. Place the file in the same directory as the        ##
##         scripts.                                                      ##
##                                                                       ##
##         util/conf$ ant                                                ##
##         util/conf$ java -jar dist/conf.jar ../csgrade.test.conf.xml   ##
##                                                                       ##
###########################################################################


def getGradeRet():
	return {
		'output':     '',
		'result':     '',
		'compOutput': '',
		'runOutput':  '',
		'diffOutput': '',
		'solOutput':  ''
	}

def getCompileRet():
	return {
		'command': '',
		'result':  '',
		'retval':  ''
	}

def getRunRet():
	return {
		'command': '',
		'result':  '',
		'retval':  ''
	}

def getDiffRet():
	return {
		'diffLines': '',
		'result':    '',
		'same':      ''
	}

def getLabDir(lab):
	return os.path.join(os.path.join(c.submittedFilesRoot, lab), 'unix')

def getBinaryPath(binaryName):
	return os.path.join(os.path.join(c.homeDirectory, 'bin'), binaryName)


# Deal with command line arguments
c = Config()
grading = False
verbose = False
moss = False
showHelp = False
assignment = None # len(assignments) # default assignment

# TODO: this should be replaced with OptParse stuff
if len(sys.argv) > 1:
	# Copy the arguments and get rid of 'test.py'
	args = sys.argv
	del args[0]
	
	for a in sys.argv:
		# Remove spaces on the ends
		arg = a.strip()
		
		# Check for flags
		if arg.startswith('-'):
			if arg == '-g':
				grading = True
			if arg == '-v':
				verbose = True
			if arg == '-m':
				moss = True
			if arg == '-h' or arg == '--help':
				showHelp = True
		else:
			# If it's not a flag, it's an argument number
			try:
				num = int(arg)
				assignment = num
			except:
				print 'Error: assignment ' + arg + ' does not exist'
				sys.exit(1)


# Variables
grades = []


# Utility functions
def mktmpnam():
	f = tempfile.NamedTemporaryFile()
	tmp = f.name
	f.close()
	return tmp

def exists(filename):
	return os.path.exists(filename)

def unlink(filename):
	if filename == None:
		return
	
	if os.path.exists(filename):
		os.unlink(filename)

def findLab(number):
	for l in c.labs:
		if int(l['num']) == int(number):
			
			return l
	
	return None

def buildFileList(studentSource, part):
	fileList = studentSource
	
	if part['sources'] != None:
		for f in part['sources']:
			fileList = fileList + ' ' + f
	
	return fileList

def make(student, lab, part, src, showOutput=False, outputFilename='', make=c.makeBinary, cd=False, studentDir=''):
	ret = getCompileRet()
	
	if cd:
		os.chdir(studentDir)
	
	# If the file doesn't exist, save time and flag it as such here
	if not exists(src):
		ret['retval'] = -1
		ret['result'] = '(-) "' + src + '" does not exist'
		ret['output'] = ''
		
		if verbose:
			print ret['result']
		
		return ret
	
	# Base compilation command
	command = make + ' -f ' + part['Makefile'] + ' clean >/dev/null 2>/dev/null && ' + make + ' -f ' + part['Makefile']
	
	# What do we do with the output?
	out = ''
	outStdout = ''
	outStderr = ''
	
	if not showOutput or grading:
		out = '>/dev/null 2>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()
		
		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out
	
	# Save the command used
	ret['command'] = command
	
	# Compile the code
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval
	
	# Log the results
	if retval == 0:
		ret['result'] = '( ) Made'
	else:
		ret['result'] = '(-) Make failed'
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
	
	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()
	
	return ret

def compile(student, lab, part, bin, src, showOutput=False, outputFilename='', compiler=c.compilerBinary):
	ret = getCompileRet()
	
	# If the file doesn't exist, save time and flag it as such here
	if not exists(src):
		ret['retval'] = -1
		ret['result'] = '(-) "' + src + '" does not exist'
		ret['output'] = ''
		
		if verbose:
			print ret['result']
		
		return ret
	
	# Base compilation command
	command = compiler + ' -o ' + bin + ' ' + buildFileList(src, part)
	
	# What do we do with the output?
	out = ''
	outStdout = ''
	outStderr = ''
	
	if not showOutput:
		out = '>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()
		
		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out
	
	# Hide output if grading
	if grading:
		command = command + ' >/dev/null 2>/dev/null'
	
	# Save the command used
	ret['command'] = command
	
	# Compile the code
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval
	
	# Log the results
	if retval == 0:
		ret['result'] = '( ) Compiled'
	else:
		ret['result'] = '(-) Compilation error'
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
	
	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()
	
	return ret

def run(student, lab, part, bin, showOutput=False, outputFilename=''):
	ret = getRunRet()

	# Base command
	command = bin
	
	# Is verbose mode on? If so, pass that on to the binary (assume -v for it as well)
	v = ''
	if verbose:
		v = '-v'
	command = command + ' ' + v

	# What do we do with the output?
	out = ''
	if not showOutput:
		out = '>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()

		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out

	# Save the command used
	ret['command'] = command

	# Run the program
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval

	# Log the results
	if retval == 0:
		ret['result'] = '( ) Ran successfully'
	else:
		ret['result'] = '(-) Program crashed'
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']

	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()

	return ret

def dualRead(file1, file2):
	o = open(file1, 'r')
	t = open(file2, 'r')
	
	return o, t

def dualClose(file1, file2):
	file1.close()
	file2.close()

def diff(student, lab, part, userFile, solFile):
	ret = getDiffRet()
	ret['diffLines'] = 0
	ret['result'] = ''
	ret['same'] = False
	
	runres = 'Wrong output'
	
	try:			
		# Count the lines in each file
		f, s = dualRead(userFile, solFile)
		fCount = 0
		sCount = 0
		for line in f:
			fCount = fCount + 1
		for line in s:
			sCount = sCount + 1
		dualClose(f, s)
		
		ret['diffLines'] = abs(fCount - sCount)
		
		# If the user has verbose mode turned on, show the contents
		# of the two files
		if verbose:
			f, s = dualRead(userFile, solFile)
			
			print student + '/' + lab['shortname'] + part['name'] + ':  ( ) ' + str(fCount) + ' lines in your output'
			for line in f:
				print '  ' + line.rstrip()
			
			print student + '/' + lab['shortname'] + part['name'] + ':  ( ) ' + str(sCount) + ' lines in solution'
			for line in s:
				print '  ' + line.rstrip()
		
		# Now, see if the contents are the same
		same = True
		if fCount != sCount:
			same = False
			
			if verbose:
				pt1 = student + '/' + lab['shortname'] + part['name'] + ':  (-) Line counts differ: '
				pt2 = str(fCount) + ' vs ' + str(sCount)
				print pt1 + pt2
		else:
			f, s = dualRead(userFile, solFile)
							
			for i in xrange(fCount):
				fLine = f.readline()
				sLine = s.readline()
				
				if fLine != sLine:
					same = False
					
					if verbose:
						print student + '/' + lab['shortname'] + part['name'] + ':  (-) Lines differ:'
						print ' >"' + fLine + '"'
						print ' >"' + sLine + '"'
					
					break
			
			dualClose(f, s)
		
		if same:
			runres = 'Correct'
		
		ret['same'] = same
	except Exception, e:
		ret['same'] = False
		runres = 'Exception thrown comparing files: ' + e.message #str(sys.exc_info()[0])
	
	if ret['same']:
		ret['result'] = '(+) Correct'
	else:
		ret['result'] = '(-) ' + runres
	
	return ret


# Grading functions
def gradeIntmatch(student, lab, part, solution):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	studentDir = os.path.join(ldir, student)
	binpath = part['binary']
	srcpath = part['source']
	compRet = getCompileRet()
	runRet = getRunRet()
	
	if grading:
		binpath = os.path.join(studentDir, part['binary'])
		srcpath = os.path.join(studentDir, part['source'])
	
	# Compile the code
	if grading:
		compRet = compile(student, lab, part, binpath, srcpath)
	else:
		ret['compOutput'] = mktmpnam()
		compRet = compile(student, lab, part, binpath, srcpath, True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		if ret['result'] == '(-) "' + srcpath + '" does not exist':
			ret['output'] = ''
		return ret
	else:
		# We want to save the output to a file in all cases since we'll be
		# determining correctness by reading from it
		ret['runOutput'] = mktmpnam()
		runRet = run(student, lab, part, binpath, True, ret['runOutput'])
	
	# Did the program run correctly?
	if runRet['retval'] != 0:
		ret['result'] = runRet['result']
		ret['output'] = ret['runOutput']
		return ret
	else:
		ret['output'] = None
		runres = '(-) Wrong output'
		
		try:
			f = open(ret['runOutput'], 'r')
		
			try:
				number = int(f.read())
		
				if number == solution:
					runres = '(+) Correct'
			finally:
				f.close()
		except:
			pass
		
		ret['result'] = runres
	
	return ret

def gradeTxtmatch(student, lab, part, solutionFile):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	studentDir = os.path.join(ldir, student)
	binpath = part['binary']
	srcpath = part['source']
	compRet = getCompileRet()
	runRet = getRunRet()
	
	if grading:
		binpath = os.path.join(studentDir, part['binary'])
		srcpath = os.path.join(studentDir, part['source'])
	
	# Compile the code
	if grading:
		compRet = compile(student, lab, part, binpath, srcpath)
	else:
		ret['compOutput'] = mktmpnam()
		compRet = compile(student, lab, part, binpath, srcpath, True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		if ret['result'] == '(-) "' + srcpath + '" does not exist':
			ret['output'] = ''
		return ret
	else:
		# We want to save the output to a file in all cases since we'll be
		# determining correctness by reading from it
		ret['runOutput'] = mktmpnam()
		runRet = run(student, lab, part, binpath, True, ret['runOutput'])
	
	# Did the program run correctly?
	if runRet['retval'] != 0:
		ret['result'] = runRet['result']
		ret['output'] = ret['runOutput']
		return ret
	else:
		ret['output'] = None
		d = diff(student, lab, part, solutionFile, ret['runOutput'])
		ret['result'] = d['result']
	
	return ret

def gradeBinmatch(student, lab, part):
	ret = getGradeRet()
	
	# Get a filename to save the output to
	solOutput = mktmpnam()
	ret['solOutput'] = solOutput
	
	# Run the solution program
	command = part['solbin'] + ' > ' + solOutput
	binrunret = subprocess.call(command, shell=True)
	
	if verbose:
		print student + '/' + lab['shortname'] + part['name'] + ':  ' + '( ) Binrunret = ' + str(binrunret)
	
	# Grade
	ret = gradeTxtmatch(student, lab, part, solOutput)
	
	# Done
	unlink(solOutput)
	return ret

def gradeMakeRun(student, lab, part):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	
	compRet = getCompileRet()
	runRet = getRunRet()
	
	# Compile the code
	if grading:
		compRet = make(student, lab, part, part['source'], False, ret['compOutput'], c.makeBinary, True, os.path.join(ldir, student))
	else:
		ret['compOutput'] = mktmpnam()
		compRet = make(student, lab, part, part['source'], True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		#print '>>> Error running make'
		if ret['result'] == '(-) "' + part['source'] + '" does not exist':
			ret['output'] = ''
		return ret
	#else:
		## We want to save the output to a file in all cases since we'll be
		## determining correctness by reading from it
		#ret['runOutput'] = mktmpnam()
		#print student + '/' + lab['shortname'] + part['name'] + ':  ( ) Output:'
		#print '          -----------------'
		#runRet = run(student, lab, part, binpath, True, ret['runOutput'])
		#print '          -----------------'
	#
	## Did the program run correctly?
	#if runRet['retval'] != 0:
	#	ret['result'] = runRet['result']
	#	ret['output'] = ret['runOutput']
	#	return ret
	#else:
	#	ret['output'] = None
	#	runres = '( ) Program ran (cannot automatically determine correctness)'
	#	ret['result'] = runres
	
	ret['output'] = None
	ret['result'] = '( ) Program cannot be run automatically; run "' + part['binary'] + '" manually'
	
	return ret

def grade(student, lab):
	res = []
	
	for part in lab['parts']:
		ret = None
		pType = part['type']
		
		if pType == 'binmatch':
			# Compile + run the code
			ret = gradeBinmatch(student, lab, part)
		elif pType == 'txtmatch':
			# Compile + run the code
			ret = gradeTxtmatch(student, lab, part, solutionFile)
		elif pType == 'intmatch':
			solution = None
			
			if part['matchtype'] == 'bin':
				out = mktmpnam()
				command = part['solbin'] + ' > ' + out
				subprocess.call(command, shell=True)
				
				f = open(out, 'r')
				solution = int(f.read())
				f.close()
			elif part['matchtype'] == 'txt':
				f = open(part['soltxt'], 'r')
				solution = int(f.read())
				f.close()
			elif part['matchtype'] == 'static':
				solution = part['solution']
			
			# Compile + run the code
			ret = gradeIntmatch(student, lab, part, solution)
		elif pType == 'make-run':
			ret = gradeMakeRun(student, lab, part)
		else:
			print 'Error: don\'t know how to grade ' + lab['name'] + ' ' + part['name']
			sys.exit(3)
		
		# Get (and maybe print) the results
		resStr = student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
		res.append(resStr)
		
		if not grading:
			print resStr
			
			if ret['output'] != None and ret['output'] != '':
				print ''
				print 'Output:'
			
				# There was an error somewhere; print the file contents
				f = open(ret['output'], 'r')
				for line in f:
					print '   ' + line.rstrip()
				f.close()
		
		# Clean up the files we used
		unlink(ret['compOutput'])
		unlink(ret['runOutput'])
		unlink(ret['diffOutput'])
		unlink(ret['solOutput'])
	
	return res

def about():
	print c.name + ' ' + c.version
	print c.author
	print 'Licensed under ' + c.license
	print ''
	print 'Instructor:            ' + c.instructor
	print 'Compiler:              ' + c.compilerBinary
	print 'Home directory:        ' + c.homeDirectory
	print 'Code root directory:   ' + c.submittedFilesRoot
	print ''
	print ''

def help():
	print 'usage: ' + __file__ + ' [options] lab'
	print '   -h | --help:     Show this help'
	print '   -g:              Use grading mode (instructor only)'
	print '   -m:              Send code to MOSS (instructor only)'
	print '   -v:              Use verbose mode'
	print ''
	print '"lab" is the number for the lab you wish to test. You can'
	print 'obtain a list of valid numbers from your instructor (see'
	print 'instructor information above).'

if __name__ == '__main__':
	# If they requested help, regardless of other flags, show that and quit
	if showHelp:
		about()
		help()
		sys.exit(0)
	
	# Find the lab we want to check
	lab = findLab(assignment)
	if lab == None:
		print 'Error: that lab does not exist'
		sys.exit(2)
	
	if not lab['complete']:
		print 'Error: lab cannot be tested with test.py'
		sys.exit(3)
	
	# Do the actual testing/grading
	if not grading and not moss:
		student = os.environ.get('USER')
		grade(student, lab)
	else:
		# Verify the user is authorized to grade
		pw = getpass.getpass('Password: ')
		h = hashlib.sha1(pw).hexdigest()
		
		if h != c.gradingPassword:
			print 'Error: incorrect password'
			sys.exit(-42)
		
		if grading:
			grades = []
			labdir = lab['dir']
		
			for d in os.listdir(labdir):
				if os.path.isdir(os.path.join(labdir, d)):
					studentRes = grade(d, lab)
				
					for res in studentRes:
						grades.append(res)
		
			grades.sort()
			for g in grades:
				print g
		elif moss:
			for p in lab['parts']:
				if p['mossglob'] != '':
					command = c.mossBinary + ' -c ' + lab['shortname'] + p['name'] + ' -l ' + c.mossLanguage + '-m 3 '
					for b in p['basefiles']:
						command = command + ' -b ' + b + ' '
					command = command + p['mossglob']
				
					subprocess.call(command, shell=True)
