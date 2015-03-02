﻿// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

// This is a non-functional, bare bones version of what is found in Subnautica. It is not intended to work (and
// it won't!) - For example, it does not include reference to any particular UI implementation. Instead, it is 
// intended to give you hints and help towards your own implementation of the feedback system idea.

// This file uses functions contained in Riley Labrecque's Steamworks.NET: https://github.com/rlabrecque/Steamworks.NET

using UnityEngine;
using System.Collections;
using System.IO;
using Steamworks;

public class FeedbackCollector : MonoBehaviour {
	
	//Editor inputs
	public string feedbackPostUrl = "enter URL for feedback POST requests";
	
	//Screenshot - Example of data you might wish to collect
	private Texture2D screenTexture;
	
	//Form (POST request)
	private WWWForm feedbackForm;
	private string uniqueId;
	private string steamId;
	private WWW feedbackWWW;
	
	//Player position - Example of data you might wish to collect
	private GameObject player;
	private Vector3 playerPosition;
	
	//Performance - Example of data you might wish to collect
	private GameObject performanceMonitorObject;
	private float frameTimeMean30;
	private TelemetryManager telemetryManager;
	
	void Start () {	
		//Check to see if we can get a player's SteamID before proceeding.
		if (!SteamManager.Initialized)
		{
			Debug.Log ("Feedback Panel: Steamworks is not available, feedback cannot be submitted. Cancelling feedback collection.");
			Destroy (gameObject);
		}
		else
		{
			// You could choose to gather these data now, or perhaps after the player has done something
			// in your UI.
			GetPerformanceData();
			TakeScreenshot ();
			GetPlayerPosition ();
		}
	}
	
	void PackageFeedback ()
	{
		steamId = Steamworks.SteamUser.GetSteamID().ToString ();
		uniqueId = getHashSha256 (ref steamId);
		
		// Here we form our WWWForm POST request. Use the AddField method to add all the data you would like
		// to collect. Some examples of data collected in Subnautica are included below for inspiration.
		
		feedbackForm = new WWWForm();
		feedbackForm.AddField("unique_id", uniqueId);
		//Position
		feedbackForm.AddField ("position_x", playerPosition.x.ToString ());
		feedbackForm.AddField ("position_y", playerPosition.y.ToString ());
		feedbackForm.AddField ("position_z", playerPosition.z.ToString ());
		//System info
		feedbackForm.AddField ("cpu", SystemInfo.processorType + " ("+SystemInfo.processorCount+" logical processors)");
		feedbackForm.AddField ("gpu", SystemInfo.graphicsDeviceName + " ("+SystemInfo.graphicsMemorySize+"MB)");
		feedbackForm.AddField ("ram", SystemInfo.systemMemorySize);
		feedbackForm.AddField ("os", SystemInfo.operatingSystem);
		//Performance
		feedbackForm.AddField ("mean_frame_time_30", frameTimeMean30.ToString());
		//Screenshot
		byte[] screenshotArray = screenTexture.EncodeToJPG();
		feedbackForm.AddBinaryData("screenshot", screenshotArray, "ingameScreenshot.jpg", "image/jpeg");
		
		//Send the request
		WWW feedbackWWW = new WWW(feedbackPostUrl, feedbackForm);
		StartCoroutine(SendFeedback(feedbackWWW));
	}
	
	// We hash the player's SteamID for privacy (In Subnautica's implementation, all data generated by the game is 
	// publicly available)
	string getHashSha256 (ref string SteamID)
	{
		byte[] bytes = System.Text.Encoding.UTF8.GetBytes (SteamID + "ReplaceMe");
		System.Security.Cryptography.SHA256Managed hashstring = new System.Security.Cryptography.SHA256Managed();
		byte[] hash = hashstring.ComputeHash(bytes);
		string hashString = string.Empty;
		foreach (byte x in hash)
		{
			hashString += System.String.Format("{0:x2}", x);
		}
		return hashString;
	}
	
	void GetPlayerPosition ()
	{
		player = GameObject.FindWithTag ("Player");
		playerPosition = player.transform.position;
	}
	
	private IEnumerator SendFeedback (WWW w)
	{
		feedbackWWW = w;
		Debug.Log ("Feedback Panel: Sending feedback report with sender unique ID " + uniqueId);
		InvokeRepeating ("UploadProgress", 0.0f, 0.5f);
		yield return w;
		if (!System.String.IsNullOrEmpty(w.error))
		{
			Debug.Log ("Feedback Panel: Error! " + w.error);
		}
		else
		{
			Debug.Log ("Feedback Panel: Backend response: " + w.data.ToString());
		}
		
	}
	
	private IEnumerator CollectScreenshot (int width, int height)
	{
		yield return new WaitForEndOfFrame();
		Texture2D texture = new Texture2D (width, height, TextureFormat.RGB24, true);
		texture.ReadPixels(new Rect(0,0, width, height),0,0);
		texture.Apply ();
		screenTexture = texture;
	}
	
	void UploadProgress ()
	{
		
		int sendingPc = Mathf.Round(feedbackWWW.uploadProgress * 100);
		Debug.Log ("Feedback Panel: Upload progress - " + sendingPc.ToString () + "%");
		if (sendingPc.Equals(100))
		{
			Invoke ("CloseSendingPanel",1.5f); //Delay gives user time to see successful transmission
		}
	}
	
	void TakeScreenshot ()
	{
		StartCoroutine (CollectScreenshot(Screen.width, Screen.height));
	}
	
	void GetPerformanceData ()
	{
		performanceMonitorObject = GameObject.FindWithTag ("TelemetryManager");
		telemetryManager = performanceMonitorObject.GetComponent<TelemetryManager>();
		frameTimeMean30 = telemetryManager.frameTimeMean30;
	}
	
	void GetPlayerPosition ()
	{
		player = GameObject.FindWithTag ("Player");
		playerPosition = player.transform.position;
	}
}