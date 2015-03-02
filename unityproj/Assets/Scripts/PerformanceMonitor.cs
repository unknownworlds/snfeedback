// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

// This is a non-functional, bare bones version of what is found in Subnautica. It is not 
// intended to work (and "out of the box." Instead, it is intended to give you hints and 
// help towards your own implementation of the feedback system idea.

// Assign this script to an object in your scene and tag it as "PerformanceMonitor" to provide 
// performance data to a feedback collector object.


using UnityEngine;
using System.Collections;

public class PerformanceMonitor : MonoBehaviour {

	//Editor variables
	public int frameSampleSize = 30;

	//Frames
	private int[] frames;
	private int frame = 1;
	private int time;
	private int totalTime;
	public float frameTimeMean;

	void Update () {
		frames [frame] = (int) (Time.deltaTime * 1000);
		
		if (frame == (frameSampleSize - 1))
		{
			foreach (int i in frames) totalTime += i;
			frameTimeMean = (totalTime / 30);
			frame = 0;
			totalTime = 0;
		}
		else
		{
			frame++;
		}
	}
}
