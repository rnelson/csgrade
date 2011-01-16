package org.pretendamazing.csgrade.util.conf;
import java.io.*;
import java.util.ArrayList;
import java.util.Scanner;

public class Main {
	public static void main(String[] args) throws Exception {
		// Make sure the user gave us a filename
		if (args.length != 1) {
			System.err.println("usage: java -jar conf.jar <config file>");
			return;
		}
		
		// Grab the filename and see if the file exists
		String filename = args[0];
		boolean exists = (new File(filename)).exists();
		
		// Decide what to do based on whether or not the file exists
		if (exists) {
			// Read in the configuration from the file
			Configuration c = Configuration.deserialize(filename);
			
			// Go to the main menu to configure labs
			Main me = new Main();
			if (me.mainMenu(c)) {
				// Save the configuration
				c.serialize(filename);
			}
		}
		else {
			// Ask if we should create a configuration there
			if ((new Main()).promptYesNo("File \"" + filename + "\" does not exist. Create?", true)) {
				// Start out getting the class data
				Configuration c = new Configuration();
				
				Main me = new Main();
				me.getClassSettings(c);
				
				// Go to the main menu to configure labs
				if (me.mainMenu(c)) {
					// Save the configuration
					c.serialize(filename);
				}
			}
			else {
				return;
			}
		}
	}
	
	public boolean mainMenu(Configuration c) throws Exception {
		System.out.println("test.py Conf");
		System.out.println("------------");
		
		while (true) {
			System.out.println("");
			this.listLabs(c);
			System.out.println("");
			System.out.println("1. Add lab");
			System.out.println("2. Modify lab");
			System.out.println("3. Remove lab");
			System.out.println("4. Save changes and exit");
			System.out.println("5. Discard changes and exit");
			
			int option = Integer.parseInt(this.prompt("Command").substring(0, 1));
			
			switch (option) {
				case 1: // Add lab
					c.lab.add(this.createLab(c));
					break;
					
				case 2: // View/modify lab
					int viewmodNumber = Integer.parseInt(this.prompt("Enter lab number").substring(0, 1)) - 1;
					Lab someLab = c.lab.get(viewmodNumber);
					this.modifyLab(c, someLab);
					break;
					
				case 3: // Remove lab
					int removeNumber = Integer.parseInt(this.prompt("Enter lab number").substring(0, 1)) - 1;
					c.lab.remove(removeNumber);
					break;
					
				case 4: // Save and exit
					return true;
					
				case 5: // Discard and exit
					return false;
			}
		}
	}
	
	public void getClassSettings(Configuration c) throws Exception {
		// Instructor information
		c.instructor = this.prompt("Enter instructor name");
		c.gradingPassword = Sha1.calculate(this.prompt("Enter password for grading"));
		
		// Filesystem information
		c.homeDirectory = this.prompt("Enter home directory (e.g., /home/grad/Classes_102/cse150efl)");
		c.submittedFilesRoot = this.prompt("Enter handin root (e.g., /home/grad/Classes_102/cse150efl/webhandin)");
		
		// Compiler and MOSS information
		c.compilerBinary = this.prompt("Enter path to compiler", c.compilerBinary);
		c.makeBinary = this.prompt("Enter path to make", c.makeBinary);
		c.mossBinary = this.prompt("Enter path to MOSS script", c.mossBinary);
		c.mossLanguage = this.prompt("Enter MOSS language", c.mossLanguage);
	}
	
	private void listLabs(Configuration c) throws Exception {
		for (int i = 0; i < c.lab.size(); i++) {
			System.out.println((i+1) + ". " + c.lab.get(i).name);
		}
	}
	
	private void listLabParts(Configuration c, Lab l) throws Exception {
		for (int i = 0; i < l.part.size(); i++) {
			System.out.println((i+1) + ". " + l.part.get(i).name);
		}
	}
	
	private Lab createLab(Configuration c) throws Exception {
		Lab l = new Lab();
		this.createModifyLab(c, l, true);
		return l;
	}
	
	private void modifyLab(Configuration c, Lab l) throws Exception {
		this.createModifyLab(c, l, false);
	}
	
	private void createModifyLab(Configuration c, Lab l, boolean isNew) throws Exception {
		// Get the basic lab information
		if (isNew) {
			l.number = Integer.parseInt(this.prompt("Enter lab number"));
			l.name = this.prompt("Enter lab name", "Week " + l.number);
			l.shortName = this.prompt("Enter lab short name", "wk" + l.number);
			l.directory = this.prompt("Enter directory", c.submittedFilesRoot + "/" + l.number + "/unix");
		}
		else {
			l.number = Integer.parseInt(this.prompt("Enter lab number", Integer.toString(l.number)));
			l.name = this.prompt("Enter lab name", l.name);
			l.shortName = this.prompt("Enter lab short name", l.shortName);
			l.directory = this.prompt("Enter directory", l.directory);
		}
		
		// Deal with the lab parts, the specific assignments
		while (true) {
			System.out.println("");
			this.listLabParts(c, l);
			System.out.println("");
			System.out.println("1. Add part");
			System.out.println("2. Modify part");
			System.out.println("3. Remove part");
			System.out.println("4. Save changes and exit");
			
			int option = Integer.parseInt(this.prompt("Command").substring(0, 1));
			
			switch (option) {
				case 1: // Add lab part
					l.part.add(this.createLabPart(c, l));
					break;
				case 2: // View/modify lab part
					int viewmodNumber = Integer.parseInt(this.prompt("Enter part number").substring(0, 1)) - 1;
					LabPart somePart = l.part.get(viewmodNumber);
					this.modifyLabPart(c, l, somePart);
					break;
					
				case 3: // Remove lab part
					int removeNumber = Integer.parseInt(this.prompt("Enter part number").substring(0, 1)) - 1;
					l.part.remove(removeNumber);
					break;
					
				case 4: // Save and exit
					// Update the number of parts
					l.numberOfParts = l.part.size();
					
					l.complete = true;
					return;
			}
		}
	}
	
	private LabPart createLabPart(Configuration c, Lab l) throws Exception {
		LabPart p = new LabPart();
		this.createModifyLabPart(c, l, p, true);
		return p;
	}
	
	private void modifyLabPart(Configuration c, Lab l, LabPart p) throws Exception {
		this.createModifyLabPart(c, l, p, false);
	}
	
	private void createModifyLabPart(Configuration c, Lab l, LabPart p, boolean isNew) throws Exception {
		boolean presentDefault = !isNew;
		
		System.out.println("");
		System.out.println("The following will configure a \"part\", a single");
		System.out.println("program as part of an overall lab/assignment.");
		
		System.out.println("");
		System.out.println("Each part has a name, e.g., \"ex1\" or \"exA\".");
		p.name = this.objectPrompt("Enter part name", p.name, presentDefault);
		
		System.out.println("");
		System.out.println("While not necessary, you can specify the output binary");
		System.out.println("to compile to. This would be useful if you want to leave");
		System.out.println("all binaries (for each part) in the current directory.");
		System.out.println("It's safe, however, to use a.out.");
		p.binary = this.prompt("Enter the binary", p.binary);
		
		System.out.println("");
		System.out.println("The script is set up to check for a specific file before");
		System.out.println("attempting to compile and test/grade the code. In most cases,");
		System.out.println("this will be the nly source file from the user. In others, it");
		System.out.println("is the main file they give.");
		p.mainSource = this.objectPrompt("Enter main source filename", p.mainSource, presentDefault);
		
		System.out.println("");
		System.out.println("Many assignments only require a single source file. In some cases,");
		System.out.println("however, multiple files are required. These may be additional files");
		System.out.println("that the student writes or files that are already written for the student.");
		if (this.promptYesNo("Do you have additional source filenames to add?")) {
			System.out.println("");
			System.out.println("The filenames can be either relative or absolute. In the case of a");
			System.out.println("relative path, it will be from one of two directories:");
			System.out.println("   1. In test mode, the directory the student is running from");
			System.out.println("   2. In grade mode, the directory for the student's submitted files");
			System.out.println("Enter filenames for each base file, END to quit.");
			System.out.println("");
			
			String fn = "";
			while (!fn.toUpperCase().trim().equals("END")) {
				fn = this.prompt("Filename");
				
				String trimmed = fn.trim();
				if (!trimmed.toUpperCase().equals("END")) {
					p.source.add(fn);
				}
			}
		}
		
		boolean typeSet = false;
		while (!typeSet) {
			System.out.println("");
			System.out.println("Each part has a different \"type\" that controls how it");
			System.out.println("is tested.");
			System.out.println("  intmatch: the student's code prints out nothing but");
			System.out.println("            an integer and that value is compared to a");
			System.out.println("            static value");
			System.out.println("  binmatch: the output of the student's binary is compared");
			System.out.println("            to the output of a reference/solution binary");
			System.out.println("  make-run: runs a specified Makefile to build the code and");
			System.out.println("            runs the compiled binary; NOTE: this does not");
			System.out.println("            attempt to judge correctness--I needed it to");
			System.out.println("            build something using cURL and didn't want to");
			System.out.println("            trust the network and thus graded manually");
			p.type = this.objectPrompt("Choose part type", p.type, presentDefault);
			
			String type = p.type.toLowerCase();
			typeSet = true;
			if (type.equals("intmatch")) {
				p.type = "intmatch";
				p.matchType = "static";
				p.solution = Integer.parseInt(this.prompt("Enter solution"));
			}
			else if (type.equals("binmatch")) {
				p.type = "binmatch";
				p.solutionBinary = this.objectPrompt("Enter reference binary path", p.solutionBinary, presentDefault);
			}
			else if (type.equals("make-run")) {
				p.type = "make-run";
				p.makefile = this.objectPrompt("Enter Makefile path", p.makefile, presentDefault);
			}
			else {
				typeSet = false;
			}
		}
		
		System.out.println("");
		System.out.println("The script can, when grading, automatically send");
		System.out.println("the students' code to MOSS to help detect cheating.");
		if (this.promptYesNo("Do you want to send results to MOSS?")) {
			System.out.println("We need a pattern to use to send the files. For example, on");
			System.out.println("wk10/ex1 in spring 2010, the glob was");
			System.out.println("  /home/grad/Classes_102/cse150efl/webhandin/10/unix/*/*.f9?");
			System.out.println("This got all student' files for week 10 that ended in .f90/.f95.");
			if (p.mossGlob.length() == 0) {
				p.mossGlob = l.directory + "/*/*.f9?";
			}
			System.out.println("");
			p.mossGlob = this.prompt("Enter MOSS glob", p.mossGlob);
			
			System.out.println("");
			System.out.println("If you gave any code to the entire class, partial files or entire");
			System.out.println("ones, you probably want to include them as \"base files\". These");
			System.out.println("are used by MOSS to ignore things that are likely going to be common");
			System.out.println("to every student.");
			if (this.promptYesNo("Do you have any base files to add?")) {
				System.out.println("");
				System.out.println("The filenames can be either relative or absolute. In the case of a");
				System.out.println("relative path, it will be from one of two directories:");
				System.out.println("   1. In test mode, the directory the student is running from");
				System.out.println("   2. In grade mode, the directory for the student's submitted files");
				System.out.println("Enter filenames for each base file, END to quit.");
				System.out.println("");
				
				String fn = "";
				while (!fn.toUpperCase().trim().equals("END")) {
					fn = this.prompt("Filename");
					
					String trimmed = fn.trim();
					if (!trimmed.toUpperCase().equals("END")) {
						p.mossBaseFile.add(fn);
					}
				}
			}
		}
	}
	
	private boolean promptYesNo(String prompt) throws Exception{
		return this.promptBoolean(prompt, new String[] {"N", "Y"}, false, false);
	}
	
	private boolean promptYesNo(String prompt, boolean defaultValue) throws Exception{
		return this.promptBoolean(prompt, new String[] {"N", "Y"}, defaultValue, true);
	}
	
	private boolean promptYesNo(String prompt, String[] options) throws Exception{
		return this.promptBoolean(prompt, options, false, false);
	}
	
	private boolean promptYesNo(String prompt, String[] options, boolean defaultValue) throws Exception{
		return this.promptBoolean(prompt, options, defaultValue, true);
	}
	
	private boolean promptBoolean(String prompt, String[] options, boolean defaultValue, boolean showDefault) throws Exception{
		String p = prompt + " (" + options[1] + ", " + options[0] + ")";
		
		String answer = "";
		while (answer.length() == 0) {
			// Ask
			answer = this.prompt(p, (defaultValue ? options[1] : options[0])).toUpperCase().trim();
			
			// If they chose the default, if applicable, set that
			if (answer.length() == 0 && showDefault) {
				return defaultValue;
			}
		}
		
		// Grab the first character
		char firstChar = answer.charAt(0);
		
		// See what they chose
		if (firstChar == options[1].charAt(0))
			return true;
		else
			return false;
	}
	
	private String objectPrompt(String prompt, String defaultValue, boolean presentDefault) throws Exception {
		if (presentDefault) {
			return this.prompt(prompt, defaultValue);
		}
		else {
			return this.prompt(prompt);
		}
	}
	
	private String prompt(String prompt) throws Exception {
		return this.prompt(prompt, "");
	}
	
	private String prompt(String prompt, String defaultValue) throws Exception {
		// Build the prompt to display
		String fullPrompt = prompt;
		if (defaultValue.length() > 0) {
			fullPrompt += " [" + defaultValue + "]";
		}
		fullPrompt += ": ";
		
		while (true) {
			// Display the prompt
			System.out.print(fullPrompt);
		
			// Get a value from the user
			InputStreamReader reader = new InputStreamReader(System.in);
			BufferedReader in = new BufferedReader(reader);
			String input = in.readLine();
		
			// Return that value, if given
			if (input != null && input.length() > 0) {
				return input;
			}
			else {
				// If they didn't enter a value but we have a default, send that back
				if (defaultValue.length() > 0) {
					return defaultValue;
				}
			}
		}
	}
}
